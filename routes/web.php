<?php

use App\Http\Controllers\TodoController;
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
    // Route::get('/comments.create', 'create')->name('comments.create');
    // Route::post('/comments.store', 'store')->name('comments.store');
});

// ソフトデリート処理(一覧、詳細、完全削除、復元)
Route::prefix('deleted-tasks')
->middleware('auth')
->group(function(){
    Route::get('index', [TodoController::class, 'deletedTasksIndex'])
    ->name('deleted-tasks.index');
    Route::get('show/{id}', [TodoController::class, 'deletedTasksShow'])
    ->name('deleted-tasks.show');
    Route::delete('destroy/{id}', [TodoController::class, 'deletedTasksDestroy'])
    ->name('deleted-tasks.destroy');
    Route::get('records/{id}/restore', [TodoController::class, 'deletedTasksRestore'])
    ->name('deleted-tasks.restore');
});

Route::get('/comments/create/{task_id}','\App\Http\Controllers\CommentController@create')->name('comments.create');

Route::post('/comments','\App\Http\Controllers\CommentController@store')->name('comments.store');
