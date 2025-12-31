<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OsController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\EstoqueItemController;
use App\Http\Controllers\DepositoItemController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\TransferenciaController;
use App\Http\Controllers\EstoqueController;


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
| As OS e Estoque precisam estar autenticadas 
|   e o servidor irá fazer essa verificação
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function(){
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
    | Ordens de Serviço
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth','setor:1,2,3'])->prefix('ordens')->name('ordens.')->group(function () {
        //Listas OS Finalizadas
        Route::get('/finalizadas',[OsController::class, 'finalizadas'])->name('finalizadas');
        
        //CRUD OS
        Route::get('/', [OsController::class, 'index'])->name('index');
        
        Route::get('/nova', [OsController::class, 'create'])->name('create');

        Route::post('/', [OsController::class, 'store'])->name('store');

        Route::get('/{id}', [OsController::class, 'show'])->name('show');

        Route::get('/{id}/edit', [OsController::class, 'edit'])->name('edit');

        Route::put('/{id}', [OsController::class, 'update'])->name('update');

        Route::delete('/{id}', [OsController::class, 'destroy'])->name('destroy');
        
        //adicionar comentario
        Route::post('/{id}/comentario',[OsController::class, 'adicionarComentario'])
        ->middleware('auth')
        ->name('comentario');
        
        //adicionar foto
        Route::post('/{id}/foto',[OsController::class, 'adicionarFoto'])->name('foto');

        // finalizar OS
        Route::post('/{id}/finalizar',[OsController::class, 'finalizarOs'])->name('finalizar');
        

    });

    /*
    |--------------------------------------------------------------------------
    | Estoque
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth','setor:1,3,4'])
        ->prefix('estoque')
        ->name('estoque.')
        ->group(function () {
            Route::get('/', [EstoqueController::class, 'index'])->name('index');
            
            /*
            |--------------------------------------------------------------------------
            | Produtos
            | /estoque/produtos
            |--------------------------------------------------------------------------
            */
            Route::prefix('produtos')->name('produtos.')->group(function(){
                Route::get('/',[ProdutoController::class, 'index'])->name('index');
                Route::get('/criar',[ProdutoController::class, 'create'])->name('create');
                Route::post('/',[ProdutoController::class, 'store'])->name('store');
                Route::get('/{id}/editar',[ProdutoController::class, 'edit'])->name('edit');
                Route::put('/{id}',[ProdutoController::class, 'update'])->name('update');
                Route::delete('/{id}',[ProdutoController::class, 'destroy'])->name('destroy');
            });
            /*
            |--------------------------------------------------------------------------
            | Estoque da Cozinha ou Estoque Seco
            | /estoque/itens
            |--------------------------------------------------------------------------
            */
            Route::prefix('itens')->name('itens.')->group(function() {
                Route::get('/',[EstoqueItemController::class, 'index'])->name('index');
                Route::get('/criar',[EstoqueItemController::class, 'create'])->name('create');
                Route::post('/',[EstoqueItemController::class, 'store'])->name('store');
                Route::get('/{id}/editar',[EstoqueItemController::class, 'edit'])->name('edit');
                Route::put('/{id}',[EstoqueItemController::class, 'update'])->name('update');
                Route::delete('/{id}',[EstoqueItemController::class, 'destroy'])->name('destroy');
            });
            /*
            |--------------------------------------------------------------------------
            | Depósito
            | /estoque/depositos/itens
            |--------------------------------------------------------------------------
            */
            Route::prefix('depositos/itens')->name('depositos.itens.')->group(function () {
                Route::get('/', [\App\Http\Controllers\DepositoItemController::class, 'index'])->name('index');
                Route::get('/criar', [\App\Http\Controllers\DepositoItemController::class, 'create'])->name('create');
                Route::post('/', [\App\Http\Controllers\DepositoItemController::class, 'store'])->name('store');
                Route::get('/{id}/editar', [\App\Http\Controllers\DepositoItemController::class, 'edit'])->name('edit');
                Route::put('/{id}', [\App\Http\Controllers\DepositoItemController::class, 'update'])->name('update');
                Route::delete('/{id}', [\App\Http\Controllers\DepositoItemController::class, 'destroy'])->name('destroy');
            });
    });

    
    
    Route::middleware(['auth','setor:1'])->prefix('admin')->name('admin.')->group(function () {

        // Página inicial da Administração
        Route::get('/', [AdminController::class, 'index'])->name('index');
             // usuários

    });

    Route::middleware(['auth','setor:1'])->prefix('index/usuarios')->name('usuarios.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/criar', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{id}/editar', [UserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Transferencias
    | aqui é onde acontecerá as transferencias entre deposito e estoque e condominios
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'setor:1,3,4'])->prefix('transferencias')->name('transferencias.')->group(function () {

        Route::get('/', [TransferenciaController::class, 'index'])->name('index');
        Route::get('/criar', [TransferenciaController::class, 'create'])->name('create');
        Route::post('/', [TransferenciaController::class, 'store'])->name('store');

        // Caso futuramente haja edição:
        // Route::get('/{id}/edit', [TransferenciaController::class, 'edit'])->name('edit');
        // Route::put('/{id}', [TransferenciaController::class, 'update'])->name('update');

    });

});

