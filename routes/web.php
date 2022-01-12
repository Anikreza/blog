<?php

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

Route::get('/', [WebsiteController::class, 'index'])->name('home');

//Route::get('/articleDetail', function () {
//    return view('pages.articleDetail.index');
//});

Route::get('/{slug}', [WebsiteController::class, 'articleDetails'])->name('article-details');

