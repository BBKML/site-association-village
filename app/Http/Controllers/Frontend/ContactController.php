<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Services\ContactValidationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    protected $validationService;

    public function __construct(ContactValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    /**
     * Afficher la page de contact
     */
    public function index()
    {
        return view('frontend.contact');
    }

    /**
     * Traiter le formulaire de contact
     */
    public function store(Request $request)
    {
        // Vérifier si l'IP est blacklistée
        if ($this->validationService->isIpBlacklisted($request->ip())) {
            Log::warning('Tentative de contact depuis IP blacklistée', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
            
            return back()->withErrors([
                'spam' => 'Votre adresse IP a été temporairement bloquée pour des raisons de sécurité.'
            ])->withInput();
        }

        // Validation complète avec le service
        $errors = $this->validationService->validateContact($request);

        if (!empty($errors)) {
            // Si c'est du spam, blacklister l'IP
            if (isset($errors['spam'])) {
                $this->validationService->blacklistIp($request->ip());
            }
            
            return back()->withErrors($errors)->withInput();
        }

        try {
            // Nettoyer et formater les données
            $cleanData = $this->validationService->sanitizeData($request->all());
            
            // Créer le contact
            $contact = Contact::create([
                'name' => $cleanData['name'],
                'email' => $cleanData['email'],
                'phone' => $cleanData['phone'],
                'subject' => $cleanData['subject'],
                'message' => $cleanData['message'],
                'ip_address' => $cleanData['ip_address'],
                'user_agent' => $cleanData['user_agent'],
                'is_read' => false,
            ]);

            // Log de succès
            Log::info('Nouveau message de contact reçu', [
                'contact_id' => $contact->id,
                'name' => $contact->name,
                'email' => $contact->email,
                'ip' => $contact->ip_address
            ]);

            return redirect()->route('contact')->with('success', 
                'Votre message a été envoyé avec succès ! Nous vous répondrons dans les plus brefs délais.'
            );

        } catch (\Exception $e) {
            Log::error('Erreur lors de la création du contact', [
                'error' => $e->getMessage(),
                'data' => $cleanData ?? $request->all()
            ]);

            return back()->withErrors([
                'general' => 'Une erreur est survenue lors de l\'envoi du message. Veuillez réessayer.'
            ])->withInput();
        }
    }
} 