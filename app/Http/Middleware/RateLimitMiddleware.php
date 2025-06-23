<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class RateLimitMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $type = 'default'): Response
    {
        $key = $this->resolveRequestSignature($request, $type);
        
        if (RateLimiter::tooManyAttempts($key, $this->getMaxAttempts($type))) {
            return $this->buildResponse($key, $type);
        }

        RateLimiter::hit($key, $this->getDecayMinutes($type) * 60);

        $response = $next($request);

        return $this->addHeaders(
            $response, $this->getMaxAttempts($type),
            $this->calculateRemainingAttempts($key, $this->getMaxAttempts($type))
        );
    }

    /**
     * Résout la signature de la requête
     */
    protected function resolveRequestSignature(Request $request, string $type): string
    {
        $identifier = $request->ip();
        
        if ($request->user()) {
            $identifier = $request->user()->id;
        }
        
        return sha1($identifier . '|' . $type . '|' . $request->route()?->uri());
    }

    /**
     * Obtient le nombre maximum de tentatives selon le type
     */
    protected function getMaxAttempts(string $type): int
    {
        return match($type) {
            'login' => 5,
            'contact' => 3,
            'newsletter' => 2,
            'api' => 60,
            default => 60,
        };
    }

    /**
     * Obtient le temps de décroissance en minutes
     */
    protected function getDecayMinutes(string $type): int
    {
        return match($type) {
            'login' => 15,
            'contact' => 60,
            'newsletter' => 30,
            'api' => 1,
            default => 1,
        };
    }

    /**
     * Construit la réponse d'erreur
     */
    protected function buildResponse(string $key, string $type): Response
    {
        $retryAfter = RateLimiter::availableIn($key);
        
        $message = match($type) {
            'login' => 'Trop de tentatives de connexion. Réessayez dans ' . ceil($retryAfter / 60) . ' minutes.',
            'contact' => 'Trop de messages envoyés. Réessayez dans ' . ceil($retryAfter / 60) . ' minutes.',
            'newsletter' => 'Trop de tentatives d\'abonnement. Réessayez dans ' . ceil($retryAfter / 60) . ' minutes.',
            default => 'Trop de requêtes. Réessayez plus tard.',
        };

        return response()->json([
            'error' => 'Rate limit exceeded',
            'message' => $message,
            'retry_after' => $retryAfter,
        ], 429);
    }

    /**
     * Calcule le nombre de tentatives restantes
     */
    protected function calculateRemainingAttempts(string $key, int $maxAttempts): int
    {
        return $maxAttempts - RateLimiter::attempts($key);
    }

    /**
     * Ajoute les en-têtes de rate limiting
     */
    protected function addHeaders(Response $response, int $maxAttempts, int $remainingAttempts): Response
    {
        $response->headers->set('X-RateLimit-Limit', $maxAttempts);
        $response->headers->set('X-RateLimit-Remaining', $remainingAttempts);
        
        return $response;
    }
} 