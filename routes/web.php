<?php

use App\Http\Controllers\TodoController;


use App\Http\Controllers\BookmarkController;
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
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


require __DIR__.'/auth.php';

// Route::get('/todo/edit', function () {
//     return view('todo.edit');
// });

// 初めてだとわかりにくい？
// Route::resource('todo', TodoController::class);


// こっちの方が書き方がオシャレ
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
});













Route::prefix('todo')
->middleware('auth')
->name('bookmark.')
->controller(BookmarkController::class)
->group(function(){
Route::get('/tasks/{task_id}/bookmark', 'store')->name('store');
Route::get('/bookmarks/{bookmark_id}/', 'destroy')->name('destroy');
Route::get('/bookmark', 'index')->name('index');
Route::get('/bookmarks_page/{bookmark_id}', 'destroy2')->name('destroy');
});