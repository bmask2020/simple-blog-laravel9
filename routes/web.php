<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontendController;

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



    Route::controller(FrontendController::class)->group(function(){

        Route::get('/', 'home');
        Route::get('/post/{id}', 'post_view')->name('post.view');
        Route::post('/post/comment', 'post_comment_store')->name('post.comment.store');
        Route::get('/post/comment/delete/{id}', 'post_comment_delete')->name('post.comment.delete');

        
    });



    Auth::routes();

    Route::controller(HomeController::class)->group(function(){

        Route::get('/dashboard', 'index')->name('dashboard');
        Route::get('/trashed/post', 'trashed_post')->name('trashed.post');
        Route::get('/post/add', 'post_add')->name('post.add');
        Route::post('/post/store', 'post_store')->name('post.store');
        Route::get('/post/edit/{id}',   'post_edit')->name('post.edit');
        Route::post('/post/update/{id}', 'post_update')->name('post.update');
        Route::get('/post/soft/delete/{id}', 'post_soft_delete')->name('post.soft.delete');
        Route::get('/post/restore/{id}', 'post_restore')->name('post.restore');
        Route::get('/post/force/delete/{id}', 'post_force_delete')->name('post.force.delete');

    });





