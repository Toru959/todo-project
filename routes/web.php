<?php

use App\Http\Controllers\TodoController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\SearchController;
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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


require __DIR__.'/auth.php';

// 初めてだとわかりにくい？
// Route::resource('todo', TodoController::class);


// 基本のルート設定
Route::prefix('todo')
->middleware('auth')
->name('todo.')
->controller(TodoController::class)
->group(function(){
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/', 'store')->name('store');
    Route::get('/show/{id}', 'show')->name('show');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::patch('/update/{id}', 'update')->name('update');
    Route::delete('/destroy/{id}', 'destroy')->name('destroy');
    // Route::get('/comments.create', 'create')->name('comments.create');
    // Route::post('/comments.store', 'store')->name('comments.store');
});

Route::get('/comments/create/{id}', '\App\Http\Controllers\CommentController@create')->name('comments.create');

Route::post('/comments/{id}', '\App\Http\Controllers\CommentController@store')->name('comments.store');

Route::delete('/comments/destroy/{id}','\App\Http\Controllers\CommentController@destroy')->name('comments.destroy');



Route::prefix('todo')
->middleware('auth')
->name('bookmark.')
->controller(BookmarkController::class)
->group(function(){
Route::post('/bookmark/store_destroy/', 'store_destroy')->name('store_destroy');
Route::get('/bookmark', 'index')->name('index');
Route::post('/bookmarks_page/destroy', 'destroy2')->name('destroy');
});



Route::prefix('deleted-tasks')
->middleware('auth')
->name('deleted-tasks.')
->controller(TodoController::class)
->group(function(){
    Route::get('index', 'deletedTasksIndex')->name('index');
    Route::get('show/{id}', 'deletedTasksShow')->name('show');
    Route::delete('destroy/{id}', 'deletedTasksDestroy')->name('destroy');
    Route::get('records/{id}/restore', 'deletedTasksRestore')->name('restore');
});

