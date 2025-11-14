<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\OsController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;


/*
|--------------------------------------------------------------------------
| Conexão ao Banco de dados
|--------------------------------------------------------------------------
*/
Route::get('/test-db', function () {
    try {
        \DB::connection()->getPdo();
        return 'Conexão PostgreSQL funcionando!';
    } catch (\Exception $e) {
        return 'Erro: ' . $e->getMessage();
    }
});
/*
|--------------------------------------------------------------------------
| Rota de Login/Logout
|--------------------------------------------------------------------------
*/
    Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', LogoutController::class)->name('logout');

/*
|--------------------------------------------------------------------------
| Página inicial
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

/*
|--------------------------------------------------------------------------
| As OS e Estoque precisam estar autenticadas 
|   e o servidor irá fazer essa verificação
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function(){
    /*
    |--------------------------------------------------------------------------
    | Ordens de Serviço
    |--------------------------------------------------------------------------
    */
    Route::prefix('ordens')->name('ordens.')->group(function () {

        Route::get('/', [OsController::class, 'index'])->name('index');
        
        Route::get('/nova', [OsController::class, 'create'])->name('create');

        Route::post('/', [OsController::class, 'store'])->name('store');

        Route::get('/{id}', [OsController::class, 'show'])->name('show');

        Route::get('/{id}/edit', [OsController::class, 'edit'])->name('edit');

        Route::put('/{id}', [OsController::class, 'update'])->name('update');

        Route::delete('/{id}', [OsController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Estoque
    |--------------------------------------------------------------------------
    */
    Route::prefix('estoque')->name('estoque.')->group(function () {
        Route::get('/', [EstoqueController::class, 'index'])->name('index');
    });
});