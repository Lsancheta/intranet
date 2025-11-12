<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\OsController;
use App\Http\Controllers\EstoqueController;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');


Route::prefix('ordens')->group(function(){

    Route::get('/',
    [OsController::class,
    'index'])->name('ordens.index');
    
    Route::get('/nova',
    [OsController::class,
    'create'])->name('ordens.create');

    Route::post('/',
    [OsController::class,
    'store'])->name('ordens.store');

    Route::get('/{id}',
    [OsController::class,
    'show'])->name('ordens.show');

    Route::get('/{id}/edit',
    [OsController::class,
    'edit'])->name('ordens.edit');

    Route::put('/{id}',
    [OsController::class,
    'update'])->name('ordens.update');

    Route::delete('/{id}',
    [OsController::class,
    'destroy'])->name('ordens.destroy');
});

Route::get('/estoque', function(){
    echo "Estoque";
});

Route::prefix('estoque')->group(function(){
    Route::get('/',
    [OsController::class,
    'index'])->name('estoque.index');
});