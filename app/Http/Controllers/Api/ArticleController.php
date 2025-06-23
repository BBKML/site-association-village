<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Services\SearchService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ArticleController extends Controller
{
    protected $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    /**
     * Liste des articles publiés
     */
    public function index(Request $request): JsonResponse
    {
        $articles = Article::where('published_at', '<=', now())
            ->with('category')
            ->orderBy('published_at', 'desc')
            ->paginate($request->get('per_page', 10));

        return response()->json([
            'success' => true,
            'data' => $articles->items(),
            'pagination' => [
                'current_page' => $articles->currentPage(),
                'last_page' => $articles->lastPage(),
                'per_page' => $articles->perPage(),
                'total' => $articles->total(),
            ],
        ]);
    }

    /**
     * Détail d'un article
     */
    public function show(Article $article): JsonResponse
    {
        if (!$article->published_at || $article->published_at > now()) {
            return response()->json([
                'success' => false,
                'message' => 'Article non trouvé',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $article->load('category'),
        ]);
    }

    /**
     * Recherche d'articles
     */
    public function search(Request $request): JsonResponse
    {
        $query = $request->get('q', '');
        $filters = $request->only(['category_id', 'date_from', 'date_to']);

        if (empty($query)) {
            return response()->json([
                'success' => false,
                'message' => 'Le paramètre de recherche est requis',
            ], 400);
        }

        $articles = $this->searchService->searchArticles($query, $filters);

        return response()->json([
            'success' => true,
            'data' => $articles,
            'query' => $query,
            'filters' => $filters,
        ]);
    }

    /**
     * Articles récents
     */
    public function recent(Request $request): JsonResponse
    {
        $limit = $request->get('limit', 5);

        $articles = Article::where('published_at', '<=', now())
            ->with('category')
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $articles,
        ]);
    }

    /**
     * Articles par catégorie
     */
    public function byCategory(Request $request, $categoryId): JsonResponse
    {
        $articles = Article::where('category_id', $categoryId)
            ->where('published_at', '<=', now())
            ->with('category')
            ->orderBy('published_at', 'desc')
            ->paginate($request->get('per_page', 10));

        return response()->json([
            'success' => true,
            'data' => $articles->items(),
            'pagination' => [
                'current_page' => $articles->currentPage(),
                'last_page' => $articles->lastPage(),
                'per_page' => $articles->perPage(),
                'total' => $articles->total(),
            ],
        ]);
    }
} 