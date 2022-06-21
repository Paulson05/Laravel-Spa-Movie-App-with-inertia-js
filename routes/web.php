<?php

use App\Http\Controllers\Admin\CastController;
use App\Http\Controllers\Admin\EpisodeController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\SeasonController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TvShowController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/admin',function (){
        return Inertia::render('Admin/index');
    })->name('admin.index');
    Route::middleware(['auth:sanctum', ])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', function () {
            return Inertia::render('Admin/Index');
        })->name('index');
        Route::resource('/movies', MovieController::class);
        Route::get(
            '/movies/{movie}/attach',
            [MovieAttachController::class, 'index']
        )->name('movies.attach');
        Route::post('/movies/{movie}/add-trailer', [MovieAttachController::class, 'addTrailer'])->name(
            'movies.add.trailer'
        );
        Route::post('/movies/{movie}/add-download', [MovieAttachController::class, 'addDownload'])->name(
            'movies.add.download'
        );
        Route::post('/movies/{movie}/add-casts', [MovieAttachController::class, 'addCast'])->name(
            'movies.add.casts'
        );
        Route::post('/movies/{movie}/add-tags', [MovieAttachController::class, 'addTag'])->name(
            'movies.add.tags'
        );
        Route::delete('/trailer-urls/{trailer_url}', [MovieAttachController::class, 'destroyTrailer'])->name('trailers.destroy');
        Route::delete('/downloads/{download}', [MovieAttachController::class, 'destroyDownload'])->name('downloads.destroy');
        Route::resource('/tv-shows', TvShowController::class);
        Route::resource('/tv-shows/{tv_show}/seasons', SeasonController::class);
        Route::resource('/tv-shows/{tv_show}/seasons/{season}/episodes', EpisodeController::class);
        Route::resource('/genres', GenreController::class);
        Route::resource('/casts', CastController::class);
        Route::resource('/tags', TagController::class);
    });

    Route::get('/dashboard', function () {
        return Inertia::render('Admin/index');})->name('dashboard');
});