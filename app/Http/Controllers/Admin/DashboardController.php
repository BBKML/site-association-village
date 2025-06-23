<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Event;
use App\Models\Contact;
use App\Models\NewsletterSubscriber;
use App\Models\Photo;
use App\Models\Service;
use App\Models\Team;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'articles' => Article::count(),
            'events' => Event::count(),
            'photos' => Photo::count(),
            'services' => Service::count(),
            'team_members' => Team::count(),
            'contacts' => Contact::count(),
            'newsletter_subscribers' => NewsletterSubscriber::count(),
        ];

        $recentContacts = Contact::latest()->take(5)->get();
        $upcomingEvents = Event::where('date', '>=', now())->orderBy('date')->take(5)->get();
        $recentArticles = Article::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentContacts', 'upcomingEvents', 'recentArticles'));
    }
}
