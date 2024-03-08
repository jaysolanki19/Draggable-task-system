<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('tasks.index');
});

Route::controller(TaskController::class)->group(function(){
    Route::get('tasks','index')->name('tasks.index');
    Route::get('tasks/create','create')->name('tasks.create');
    Route::post('tasks/store','store')->name('tasks.store');
    Route::get('tasks/{id}','show')->name('tasks.show');
    Route::post('delete/tasks','destroy')->name('tasks.delete');
    Route::get('task/edit/{id}','edit')->name('tasks.edit'); 
    Route::post('task/update','update')->name('tasks.update');
    Route::post('task/update/priority','updatePriority')->name('update.tasks.priority');
    Route::post('task/update/status','updateStatus')->name('tasks.update.status');
    Route::post('tasks/reorder', 'reorder')->name('tasks.reorder');
});


