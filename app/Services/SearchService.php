<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Event;
use App\Models\Service;
use App\Models\Team;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class SearchService
{
    /**
     * Recherche globale dans tous les contenus
     */
    public function globalSearch(string $query, array $filters = []): array
    {
        $results = [
            'articles' => $this->searchArticles($query, $filters['articles'] ?? []),
            'events' => $this->searchEvents($query, $filters['events'] ?? []),
            'services' => $this->searchServices($query, $filters['services'] ?? []),
            'team' => $this->searchTeam($query, $filters['team'] ?? []),
        ];

        return $results;
    }

    /**
     * Recherche dans les articles
     */
    public function searchArticles(string $query, array $filters = []): Collection
    {
        $articles = Article::query()
            ->where(function (Builder $q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%")
                  ->orWhere('excerpt', 'like', "%{$query}%");
            })
            ->where('published_at', '<=', now());

        // Filtres
        if (!empty($filters['category_id'])) {
            $articles->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['date_from'])) {
            $articles->where('published_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $articles->where('published_at', '<=', $filters['date_to']);
        }

        return $articles->orderBy('published_at', 'desc')->get();
    }

    /**
     * Recherche dans les événements
     */
    public function searchEvents(string $query, array $filters = []): Collection
    {
        $events = Event::query()
            ->where(function (Builder $q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%")
                  ->orWhere('location', 'like', "%{$query}%");
            });

        // Filtres
        if (!empty($filters['date_from'])) {
            $events->where('date', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $events->where('date', '<=', $filters['date_to']);
        }

        if (!empty($filters['status'])) {
            $events->where('status', $filters['status']);
        }

        return $events->orderBy('date', 'asc')->get();
    }

    /**
     * Recherche dans les services
     */
    public function searchServices(string $query, array $filters = []): Collection
    {
        $services = Service::query()
            ->where(function (Builder $q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->where('is_active', true);

        // Filtres
        if (!empty($filters['price_min'])) {
            $services->where('price', '>=', $filters['price_min']);
        }

        if (!empty($filters['price_max'])) {
            $services->where('price', '<=', $filters['price_max']);
        }

        return $services->orderBy('name', 'asc')->get();
    }

    /**
     * Recherche dans l'équipe
     */
    public function searchTeam(string $query, array $filters = []): Collection
    {
        $team = Team::query()
            ->where(function (Builder $q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('position', 'like', "%{$query}%")
                  ->orWhere('bio', 'like', "%{$query}%");
            })
            ->where('is_active', true);

        return $team->orderBy('name', 'asc')->get();
    }

    /**
     * Recherche avec suggestions
     */
    public function getSuggestions(string $query): array
    {
        $suggestions = [];

        // Suggestions d'articles
        $articleTitles = Article::where('title', 'like', "%{$query}%")
            ->where('published_at', '<=', now())
            ->pluck('title')
            ->take(3);

        $suggestions['articles'] = $articleTitles;

        // Suggestions d'événements
        $eventTitles = Event::where('title', 'like', "%{$query}%")
            ->pluck('title')
            ->take(3);

        $suggestions['events'] = $eventTitles;

        // Suggestions de services
        $serviceNames = Service::where('name', 'like', "%{$query}%")
            ->where('is_active', true)
            ->pluck('name')
            ->take(3);

        $suggestions['services'] = $serviceNames;

        return $suggestions;
    }

    /**
     * Recherche populaire (basée sur les mots-clés fréquents)
     */
    public function getPopularSearches(): array
    {
        // Mots-clés populaires prédéfinis
        return [
            'événements',
            'actualités',
            'services',
            'contact',
            'équipe',
            'galerie',
            'projets',
        ];
    }

    /**
     * Recherche avec mise en surbrillance
     */
    public function highlightQuery(string $text, string $query): string
    {
        if (empty($query)) {
            return $text;
        }

        $highlighted = preg_replace(
            '/(' . preg_quote($query, '/') . ')/i',
            '<mark>$1</mark>',
            $text
        );

        return $highlighted;
    }

    /**
     * Statistiques de recherche
     */
    public function getSearchStats(string $query): array
    {
        $results = $this->globalSearch($query);

        return [
            'total_results' => collect($results)->sum(fn($collection) => $collection->count()),
            'articles_count' => $results['articles']->count(),
            'events_count' => $results['events']->count(),
            'services_count' => $results['services']->count(),
            'team_count' => $results['team']->count(),
        ];
    }
} 