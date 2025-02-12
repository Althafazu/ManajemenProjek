<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DatatrialController;
use App\Http\Controllers\GamtekController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\QCController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\GanttController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function(){
    Route::get('/', [LoginController::class,'index'])->name ('login');
    Route::post('/login', [LoginController::class,'login'])->name('login.process');
});
Route::get('/home', function(){
    return view('dashboard.dashboard-proyek');
})->name('dashboard');

Route::middleware(['auth'])->group(function(){
    Route::get('/admin', [AdminController::class,'index']);
    Route::get('/admin/mahasiswa', [AdminController::class,'mahasiswa'])->middleware('UserAkses:ROL23');
    Route::get('/admin/dosen', [AdminController::class,'dosen'])->middleware('UserAkses:ROL25');
    Route::get('/logout', [LoginController::class,'logout']);
});


Route::get('/gamteks', [GamtekController::class, 'index'])->name('gamteks.index');
Route::get('/gamteks/create', [GamtekController::class, 'create'])->name('gamteks.create');
Route::post('/gamteks', [GamtekController::class, 'store'])->name('gamteks.store');
Route::get('/gamteks/download/{id}', [GamtekController::class, 'download'])->name('gamteks.download');




Route::get('/qcs', [QCController::class, 'index'])->name('qcs.index');
Route::get('/qcs/create', [QCController::class, 'create'])->name('qcs.create');
Route::post('/qcs', [QCController::class, 'store'])->name('qcs.store');
Route::get('/qcs/download/{id}', [QCController::class, 'download'])->name('qcs.download');
Route::get('/qcs/{id}', [QCController::class, 'show'])->name('qcs.show');

Route::get('/datatrials', [DatatrialController::class, 'index'])->name('datatrials.index');
Route::get('/datatrials/create', [DatatrialController::class, 'create'])->name('datatrials.create');
Route::post('/datatrials', [DatatrialController::class, 'store'])->name('datatrials.store');
Route::get('/datatrials/download/{id}', [DatatrialController::class, 'download'])->name('datatrials.download');
Route::get('/datatrials/{id}', [DatatrialController::class, 'show'])->name('datatrials.show');


Route::prefix('ap')->group(function() {
    Route::get('/{apId}', [GanttController::class, 'index'])->name('tasks.index');
    Route::get('/data/{apId}', [GanttController::class, 'getGanttData']);
    Route::get('/getAll/{ap_id}', [TaskController::class, 'getAll']);

    
    Route::get('/{apId}/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/{apId}/store', [TaskController::class, 'store'])->name('tasks.store');

    Route::put('/{apId}/update', [TaskController::class, 'update'])->name('tasks.update');
});
