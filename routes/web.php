<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\NewsletterController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\PhotoController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

// Page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('home');

// Pages statiques
Route::get('/a-propos', [PageController::class, 'about'])->name('about');
Route::get('/actions', [PageController::class, 'actions'])->name('actions');
Route::get('/actualites', [PageController::class, 'news'])->name('news');
Route::get('/actualites/{article}', [PageController::class, 'newsShow'])->name('news.show');
Route::get('/evenements', [PageController::class, 'events'])->name('events');
Route::get('/evenements/{event}', [PageController::class, 'eventShow'])->name('events.show');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/galerie', [PageController::class, 'gallery'])->name('gallery');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store')->middleware('rate.limit:contact');

// Newsletter
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe')->middleware('rate.limit:newsletter');

// CAPTCHA refresh
Route::get('/captcha/refresh', function() {
    return captcha_img();
})->name('captcha.refresh');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Articles
    Route::resource('articles', ArticleController::class);
    
    // Événements
    Route::resource('events', EventController::class);
    
    // Photos
    Route::resource('photos', PhotoController::class);
    
    // Projets
    Route::resource('projects', ProjectController::class);
    
    // Services
    Route::resource('services', ServiceController::class);
    
    // Équipe
    Route::resource('teams', TeamController::class);
    
    // Pages
    Route::resource('pages', AdminPageController::class);
    
    // Paramètres (route personnalisée pour update)
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

    // Contacts
    Route::get('contacts', [\App\Http\Controllers\Admin\ContactController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{contact}', [\App\Http\Controllers\Admin\ContactController::class, 'show'])->name('contacts.show');
    Route::post('contacts/{contact}/mark-as-read', [\App\Http\Controllers\Admin\ContactController::class, 'markAsRead'])->name('contacts.mark-as-read');
    Route::post('contacts/{contact}/mark-as-unread', [\App\Http\Controllers\Admin\ContactController::class, 'markAsUnread'])->name('contacts.mark-as-unread');
    Route::delete('contacts/{contact}', [\App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('contacts.destroy');
});

// Routes d'authentification
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('rate.limit:login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
