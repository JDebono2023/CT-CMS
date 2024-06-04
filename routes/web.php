<?php

use App\Models\media;
use Illuminate\Mail\Markdown;
use App\Http\Livewire\RecentContents;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\ClientMediaSelect;

use App\Models\category;
use App\Models\client;
use App\Models\Team;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // ELM VIEWS
    Route::get('/media', function () {
        return view('content.contentMedia');
    })->can('viewAny', media::class)->name('media');

    Route::get('/categories', function () {
        return view('category.Category');
    })->can('viewAny', category::class)->name('categories');

    Route::get('/all-users', function () {
        return view('users.AllUsers');
    })->can('viewAny', Team::class)->name('all-users');

    Route::get('/teams', function () {
        return view('teams.teams');
    })->can('viewAny', Team::class)->name('teams');


    // CLIENT VIEWS
    Route::get('/ctcategory', function () {
        return view('client.CategoryHome');
    })->can('viewAny', client::class)->name('ctcategory');

    Route::get('/ctcontent/{id}', ClientMediaSelect::class)->can('viewAny', client::class)->name('ctcontent');

    Route::get('/ctcatrecent/{id}', RecentContents::class)->can('viewAny', client::class)->name('ctcatrecent');

    // GENERAL ROUTES
    Route::get('/requestemail', function () {
        return view('emails.media-request');
    })->name('requestemail');

    // email previews
    Route::get('mail', function () {
        $markdown = new Markdown(view(), config('mail.markdown'));

        return $markdown->render('emails.media-request');
    });
});
