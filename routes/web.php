<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () { return view('welcome'); });
Route::view('cms/admin', 'cms.parent')->name('dashboard');

Route::get('cms/tasks-all/trashed', [TaskController::class, 'trashed'])->name('tasks.trashed');
Route::post('cms/tasks-restore/{task}', [TaskController::class, 'restore'])->name('tasks.restore');
Route::delete('cms/tasks-force/{task}', [TaskController::class, 'forceDelete'])->name('tasks.forceDelete');

Route::resource('cms/tasks', TaskController::class);