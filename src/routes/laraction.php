<?php


use Illuminate\Support\Facades\Route;

Route::any('laraction', [Laraction\App\Http\Controllers\ManagerController::class, 'index'])->name('laraction');
Route::any('laraction/edit/{route}', [Laraction\App\Http\Controllers\ManagerController::class, 'edit'])->name('laraction.edit');
Route::any('laraction/step3/{route}', [Laraction\App\Http\Controllers\ManagerController::class, 'step3'])->name('laraction.step3');
Route::any('laraction/action/{route}/{action}', [Laraction\App\Http\Controllers\ManagerController::class, 'action'])->name('laraction.action');
Route::any('laraction/list', [Laraction\App\Http\Controllers\ManagerController::class, 'list'])->name('laraction.list');
Route::any('laraction/tree', [Laraction\App\Http\Controllers\ManagerController::class, 'tree'])->name('laraction.tree');
Route::any('laraction/generate/{route}', [Laraction\App\Http\Controllers\ManagerController::class, 'generate'])->name('laraction.generate');