<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\Project;
use App\Models\Service;
use App\Models\Article;
use App\Models\Event;
use App\Models\Photo;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        $teamMembers = Team::where('is_active', true)->orderBy('created_at', 'asc')->get();
        return view('frontend.about', compact('teamMembers'));
    }

    public function actions()
    {
        $projects = Project::all();
        return view('frontend.actions', compact('projects'));
    }

    public function news()
    {
        $articles = Article::where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->paginate(10);
        return view('frontend.news', compact('articles'));
    }

    public function newsShow(Article $article)
    {
        return view('frontend.news-show', compact('article'));
    }

    public function events()
    {
        $events = Event::orderBy('date', 'asc')->paginate(10);
        return view('frontend.events', compact('events'));
    }

    public function eventShow(Event $event)
    {
        return view('frontend.event-show', compact('event'));
    }

    public function services()
    {
        $services = Service::all();
        return view('frontend.services', compact('services'));
    }

    public function gallery()
    {
        $photos = Photo::latest()->paginate(12);
        return view('frontend.gallery', compact('photos'));
    }
} 