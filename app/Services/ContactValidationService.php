<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ContactValidationService
{
    /**
     * Validation complète du formulaire de contact
     */
    public function validateContact(Request $request): array
    {
        $errors = [];
        
        // Validation de base
        $basicValidation = $this->validateBasicFields($request);
        if (!empty($basicValidation)) {
            $errors = array_merge($errors, $basicValidation);
        }
        
        // Validation anti-spam
        $spamValidation = $this->validateAntiSpam($request);
        if (!empty($spamValidation)) {
            $errors = array_merge($errors, $spamValidation);
        }
        
        // Validation du CAPTCHA
        $captchaValidation = $this->validateCaptcha($request);
        if (!empty($captchaValidation)) {
            $errors = array_merge($errors, $captchaValidation);
        }
        
        // Validation de la vitesse de soumission
        $speedValidation = $this->validateSubmissionSpeed($request);
        if (!empty($speedValidation)) {
            $errors = array_merge($errors, $speedValidation);
        }
        
        return $errors;
    }
    
    /**
     * Validation des champs de base
     */
    protected function validateBasicFields(Request $request): array
    {
        $errors = [];
        
        // Nom
        if (empty($request->name) || strlen($request->name) < 2) {
            $errors['name'] = 'Le nom doit contenir au moins 2 caractères.';
        } elseif (strlen($request->name) > 100) {
            $errors['name'] = 'Le nom ne peut pas dépasser 100 caractères.';
        } elseif (!preg_match('/^[a-zA-ZÀ-ÿ\s\-\']+$/', $request->name)) {
            $errors['name'] = 'Le nom ne peut contenir que des lettres, espaces, tirets et apostrophes.';
        }
        
        // Email
        if (empty($request->email) || !filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Veuillez entrer une adresse email valide.';
        } elseif (strlen($request->email) > 255) {
            $errors['email'] = 'L\'adresse email est trop longue.';
        }
        
        // Téléphone (optionnel mais doit être valide si fourni)
        if (!empty($request->phone)) {
            if (!preg_match('/^[\+]?[0-9\s\-\(\)]{8,}$/', $request->phone)) {
                $errors['phone'] = 'Veuillez entrer un numéro de téléphone valide.';
            }
        }
        
        // Sujet
        if (empty($request->subject) || strlen($request->subject) < 5) {
            $errors['subject'] = 'Le sujet doit contenir au moins 5 caractères.';
        } elseif (strlen($request->subject) > 200) {
            $errors['subject'] = 'Le sujet ne peut pas dépasser 200 caractères.';
        }
        
        // Message
        if (empty($request->message) || strlen($request->message) < 10) {
            $errors['message'] = 'Le message doit contenir au moins 10 caractères.';
        } elseif (strlen($request->message) > 2000) {
            $errors['message'] = 'Le message ne peut pas dépasser 2000 caractères.';
        }
        
        return $errors;
    }
    
    /**
     * Validation anti-spam
     */
    protected function validateAntiSpam(Request $request): array
    {
        $errors = [];
        
        // Vérification du champ honeypot
        if (!empty($request->website)) {
            $errors['spam'] = 'Message détecté comme spam.';
            Log::warning('Spam détecté via honeypot', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'data' => $request->all()
            ]);
            return $errors;
        }
        
        // Vérification des mots-clés spam
        $spamKeywords = [
            'viagra', 'casino', 'loan', 'credit', 'debt', 'free money',
            'make money fast', 'work from home', 'weight loss',
            'click here', 'buy now', 'limited time', 'act now'
        ];
        
        $content = strtolower($request->message . ' ' . $request->subject);
        foreach ($spamKeywords as $keyword) {
            if (str_contains($content, $keyword)) {
                $errors['spam'] = 'Le message contient du contenu non autorisé.';
                Log::warning('Spam détecté via mots-clés', [
                    'ip' => $request->ip(),
                    'keyword' => $keyword,
                    'content' => $content
                ]);
                break;
            }
        }
        
        // Vérification des liens multiples
        $linkCount = preg_match_all('/https?:\/\/[^\s]+/', $request->message);
        if ($linkCount > 2) {
            $errors['spam'] = 'Trop de liens dans le message.';
            Log::warning('Spam détecté via liens multiples', [
                'ip' => $request->ip(),
                'link_count' => $linkCount
            ]);
        }
        
        // Vérification de la répétition excessive
        $words = explode(' ', strtolower($request->message));
        $wordCount = array_count_values($words);
        foreach ($wordCount as $word => $count) {
            if (strlen($word) > 3 && $count > 5) {
                $errors['spam'] = 'Répétition excessive détectée dans le message.';
                Log::warning('Spam détecté via répétition', [
                    'ip' => $request->ip(),
                    'word' => $word,
                    'count' => $count
                ]);
                break;
            }
        }
        
        return $errors;
    }
    
    /**
     * Validation du CAPTCHA
     */
    protected function validateCaptcha(Request $request): array
    {
        // Désactive toute validation CAPTCHA en environnement de test
        if (app()->environment('testing')) {
            return [];
        }
        $errors = [];
        if (empty($request->captcha)) {
            $errors['captcha'] = 'Veuillez saisir le code de sécurité.';
        } elseif (!captcha_check($request->captcha)) {
            $errors['captcha'] = 'Le code de sécurité est incorrect.';
            Log::warning('CAPTCHA incorrect', [
                'ip' => $request->ip(),
                'provided' => $request->captcha
            ]);
        }
        return $errors;
    }
    
    /**
     * Validation de la vitesse de soumission
     */
    protected function validateSubmissionSpeed(Request $request): array
    {
        $errors = [];
        
        // Skip speed validation in testing environment
        if (app()->environment('testing')) {
            return $errors;
        }
        
        $ip = $request->ip();
        $cacheKey = "contact_submission_{$ip}";
        
        // Vérifier si l'utilisateur a soumis un formulaire récemment
        if (Cache::has($cacheKey)) {
            $lastSubmission = Cache::get($cacheKey);
            $timeDiff = time() - $lastSubmission;
            
            if ($timeDiff < 30) { // 30 secondes minimum entre soumissions
                $errors['speed'] = 'Veuillez attendre 30 secondes avant de soumettre un nouveau message.';
                Log::warning('Soumission trop rapide', [
                    'ip' => $ip,
                    'time_diff' => $timeDiff
                ]);
            }
        }
        
        // Enregistrer cette soumission
        Cache::put($cacheKey, time(), 300); // 5 minutes
        
        return $errors;
    }
    
    /**
     * Nettoyer et formater les données
     */
    public function sanitizeData(array $data): array
    {
        return [
            'name' => trim(strip_tags($data['name'] ?? '')),
            'email' => trim(strtolower($data['email'] ?? '')),
            'phone' => trim($data['phone'] ?? ''),
            'subject' => trim(strip_tags($data['subject'] ?? '')),
            'message' => trim(strip_tags($data['message'] ?? '')),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ];
    }
    
    /**
     * Vérifier si l'IP est blacklistée
     */
    public function isIpBlacklisted(string $ip): bool
    {
        $blacklistedIps = Cache::get('blacklisted_ips', []);
        return in_array($ip, $blacklistedIps);
    }
    
    /**
     * Ajouter une IP à la blacklist
     */
    public function blacklistIp(string $ip): void
    {
        $blacklistedIps = Cache::get('blacklisted_ips', []);
        if (!in_array($ip, $blacklistedIps)) {
            $blacklistedIps[] = $ip;
            Cache::put('blacklisted_ips', $blacklistedIps, 86400); // 24 heures
        }
    }
} 