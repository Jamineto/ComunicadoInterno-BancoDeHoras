<?php

use App\Http\Controllers\BancoController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ComunicadoController;
use App\Http\Controllers\AdminController;
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
    return redirect()->route('all_comunicados');
});

Route::get('/teste', function (){
   return view('banco.dashboard');
});

Route::middleware(['auth'])->group(function () {

    Route::prefix('comunicados')->group(function () {
        Route::get('/todos',[ComunicadoController::class,'index'])->name('all_comunicados');
        Route::get('/visualizados',[ComunicadoController::class,'viewed'])->name('viewed_comunicados');
        Route::get('/enviados',[ComunicadoController::class,'sent'])->name('sent_comunicados');
        Route::get('/criar',[ComunicadoController::class,'create'])->name('create_comunicado');
        Route::get('/visualiza/{id}',[ComunicadoController::class,'show'])->name('show_comunicado');
        Route::post('/store',[ComunicadoController::class,'store'])->name('store_comunicado');
    });

    Route::prefix('bancodehoras')->group(function () {
        Route::get('/funcionario/{id}',[BancoController::class,'dashboard'])->name('banco_dash');
        Route::get('/aviso',[BancoController::class,'warning'])->name('warning_compensada');
        Route::get('/todos',[BancoController::class,'index'])->name('index_horas');
        Route::get('/criar',[BancoController::class,'create_banco'])->name('create_banco_horas');
        Route::get('/compensada',[BancoController::class,'create_compensada'])->name('create_compensada');
        Route::post('/store',[BancoController::class,'store_banco'])->name('store_banco');
        Route::post('/store_compensada',[BancoController::class,'store_compensada'])->name('store_compensada');
        Route::post('/funcionarios/{id}',[BancoController::class,'show_horas'])->name('show_horas');
        Route::get('/visualiza/{id}',[BancoController::class,'show'])->name('show_banco');
        Route::middleware(['supervisor'])->group(function () {
            Route::get('/solicitacoes',[BancoController::class,'solicitacoes'])->name('solicitacoes_banco');
        });
    });

    Route::post('/usuario/marcar/lido/{id}',[ComunicadoController::class,'markAsViewed'])->name('mark_viewed');
    Route::post('/usuario/marcar/naolido/{id}',[ComunicadoController::class,'markAsNotViewed'])->name('mark_not_viewed');
});

Route::middleware(['admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard',[AdminController::class,'index'])->name('admin_index');

        Route::get('/trocar-status/{id}/{status}',[AdminController::class,'trocaStatus'])->name('troca_status');
        Route::get('/importar',function (){
            return view('admin.importar-funcionario');
        })->name('importar');
        Route::post('/importa/funcionario',[AdminController::class,'importaFunc'])->name('importaFunc');

        Route::get('/criar/setores',[AdminController::class,'create_setores'])->name('create_setores');
        Route::get('/criar/categorias',[AdminController::class,'create_funcionarios'])->name('create_funcionarios');

        Route::get('/editar/usuario/{id}',[AdminController::class,'edit_usuario'])->name('edit_usuario');
        Route::get('/editar/setor/{id}',[AdminController::class,'edit_setores'])->name('edit_setores');
        Route::get('/editar/funcionario/{id}',[AdminController::class,'edit_funcionarios'])->name('edit_funcionarios');

        Route::get('/pesquisa/usuarios',[AdminController::class,'search_usuarios'])->name('search_usuarios');
        Route::get('/pesquisa/setores',[AdminController::class,'search_setores'])->name('search_setores');
        Route::get('/pesquisa/funcionarios',[AdminController::class,'search_funcionarios'])->name('search_funcionarios');

        Route::get('/search/usuarios',[AdminController::class,'search_usuarios_ajax'])->name('search_usuarios_ajax');
        Route::get('/search/setores',[AdminController::class,'search_setores_ajax'])->name('search_setores_ajax');
        Route::get('/search/funcionarios',[AdminController::class,'search_funcionarios_ajax'])->name('search_funcionarios_ajax');

        Route::post('/store/setor',[AdminController::class,'store_setor'])->name('store_setor');
        Route::post('/store/categorias',[AdminController::class,'store_funcionario'])->name('store_funcionarios');

        Route::put('/update/usuario/{id}',[AdminController::class,'update_usuario'])->name('update_usuario');
        Route::put('/update/setor/{id}',[AdminController::class,'update_setor'])->name('update_setor');
        Route::put('/update/funcionario/{id}',[AdminController::class,'update_funcionario'])->name('update_funcionarios');

        Route::delete('/delete/funcionario/{id}',[AdminController::class,'destroy_funcionario'])->name('destroy_funcionario');
        Route::delete('/delete/setor/{id}',[AdminController::class,'destroy_setor'])->name('destroy_setor');
        Route::delete('/delete/usuario/{id}',[AdminController::class,'destroy_usuario'])->name('destroy_usuario');

        Route::get('/comunicados/filtros/{filtro}',[AdminController::class,'filtros'])->name('admin_filtros');
        Route::get('/comunicados/{tipo}/{filtro}',[AdminController::class,'adminComu'])->name('admin_comunicados');

        Route::get('/bancodehoras/filtros/{filtro}',[AdminController::class,'filtrosBanco'])->name('admin_filtros_banco');
        Route::get('/bancodehoras/{filtro}',[AdminController::class,'adminBanco'])->name('admin_banco');
    });
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
