<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Event;
use App\Models\Photo;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Récupérer les 3 dernières actualités publiées
        $recentArticles = Article::where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        // Récupérer les 3 prochains événements
        $upcomingEvents = Event::where('date', '>=', now())
            ->orderBy('date', 'asc')
            ->take(3)
            ->get();

        // Récupérer les 8 dernières photos
        $recentPhotos = Photo::orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        return view('frontend.home', compact('recentArticles', 'upcomingEvents', 'recentPhotos'));
    }
}
