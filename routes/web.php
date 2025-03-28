<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TaskController;
use App\Models\Store;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



// manager create teammates list and store
Route::prefix('manager/')->middleware('auth')->name('manager.')->group(function () {
    Route::get('/create-teammates-list', [ManagerController::class, 'create_teammates_list'])->name('create_teammates_list');
    Route::delete('/destroy', [ManagerController::class, 'destroy'])->name('destroy');
    Route::post('/teammates-store', [ManagerController::class, 'teammates_store'])->name('teammates_store');
});


// Create Project
Route::prefix('manager/')->middleware('auth')->name('Project.')->group(function () {
    Route::get('/create-project-list', [ProjectController::class, 'create_project_list'])->name('create_project_list');
    Route::get('/delete', [ProjectController::class, 'delete'])->name('delete');
    Route::post('/project-store', [ProjectController::class, 'project_store'])->name('project_store');
    Route::get('/project-wise-task-filter', [ProjectController::class, 'project_wise_task_filter'])->name('project_wise_task_filter');
});



// Create task
Route::prefix('manager/')->middleware('auth')->name('task.')->group(function () {
    Route::get('/destroy', [TaskController::class, 'destroy'])->name('destroy');
    Route::get('/create-task-assign-list', [TaskController::class, 'create_task_assign_list'])->name('create_task_assign_list');
    Route::get('/task-status-update', [TaskController::class, 'task_status_update'])->name('task_status_update');
    Route::post('/task-store', [TaskController::class, 'task_store'])->name('task_store');
});


