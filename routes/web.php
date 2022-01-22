<?php

use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

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

/**
 * PUBLIC ROUTES
 */

Route::get('/', [WebsiteController::class, 'index'])->name('home');
Route::get('/articles/{slug}', [WebsiteController::class, 'articleDetails'])->name('article-details');
Route::get('/category/{slug}', [WebsiteController::class, 'categoryDetails'])->name('category');
Route::get('/search', [WebsiteController::class, 'searchArticle'])->name('search');
Route::get('tag/{slug}', [WebsiteController::class, 'tagDetails'])->name('tag');
Route::get('/columnist', [WebsiteController::class, 'getColumnistPage'])->name('get-columnist');

/**
 * ADMIN ROUTES
 */
Route::get('/dashboard/{any}', [ApplicationController::class, 'index'])->where('any', '(.*)');

