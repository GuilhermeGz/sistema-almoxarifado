<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('sistema', function () {
    return view('infos.sistema');
})->name('sistema');
Route::get('parceria', function () {
    return view('infos.parceria');
})->name('parceria');
Route::get('contato', function () {
    return view('infos.contato');
})->name('contato');

Route::middleware(['auth', 'verified', 'CheckCargoAdministrador'])->group(function () {
    Route::resource('notificacao', 'NotificacaoController');
    Route::get('notificacao/{notificacao_id}', 'NotificacaoController@show')->name('notificacao.show');
    Route::get('notificacoes', 'NotificacaoController@index')->name('notificacao.index');

    Route::get('material/index_edit', 'MaterialController@indexEdit')->name('material.indexEdit');
    Route::get('material/{id}/remover', 'MaterialController@destroy')->name('material.deletar');

    Route::get('recibo/{id}', 'UnidadeController@listarRecibos')->name('unidade.recibos');
    Route::get('recibo/{id}/download', 'SolicitacaoController@gerarRecibo')->name('unidade.recibo.baixar');

    Route::get('nova_entrada_form', 'MovimentoController@createEntrada')->name('movimento.entradaCreate');
    Route::get('nova_saida_form', 'MovimentoController@createSaida')->name('movimento.saidaCreate');
    Route::get('transferencia_form', 'MovimentoController@createTransferencia')->name('movimento.transferenciaCreate');

    Route::post('movimento_entrada', 'MovimentoController@entradaStore')->name('movimento.entradaStore');
    Route::post('movimento_saida', 'MovimentoController@saidaStore')->name('movimento.saidaStore');
    Route::post('movimento_transferencia', 'MovimentoController@transferenciaStore')->name('movimento.transferenciaStore');

    Route::resource('deposito', 'DepositoController');
    Route::get('deposito/{id}/remover', 'DepositoController@destroy')->name('deposito.destroy');

    Route::resource('cargo', 'CargoController');

    Route::resource('solicita', 'SolicitacaoController');

    Route::get('setores', 'SetorController@index')->name('index.setor');
    Route::get('setor/remover/{id}', 'SetorController@remover')->name('remover.setor');
    Route::post('setor/store', 'SetorController@store')->name('store.setor');
    Route::post('setor/update', 'SetorController@update')->name('update.setor');

    Route::get('ordemFornecimento/index', 'OrdemFornecimentoController@index')->name('index.ordemFornecimento');
    Route::get('ordemFornecimento/cadastrar', 'OrdemFornecimentoController@cadastrar')->name('cadastrar.ordemFornecimento');
    Route::get('ordemFornecimento/editar/{id}', 'OrdemFornecimentoController@editar')->name('editar.ordemFornecimento');
    Route::post('ordemFornecimento/store', 'OrdemFornecimentoController@store')->name('store.ordemFornecimento');
    Route::post('ordemFornecimento/update', 'OrdemFornecimentoController@update')->name('update.ordemFornecimento');
    Route::get('ordemFornecimento/remover/{id}', 'OrdemFornecimentoController@remover')->name('remover.ordemFornecimento');


    Route::get('nota/{id}', 'NotasController@index')->name('index.nota');
    Route::get('cadastrar_nota/{id}', 'NotasController@cadastrar')->name('cadastrar.nota');
    Route::post('criar_nota', 'NotasController@create')->name('criar.nota');
    Route::get('nota/edit/{id}', 'NotasController@edit')->name('edit.nota');

    Route::get('configurar_notas', 'NotasController@configurar')->name('config.nota');
    Route::post('alterar_config_notas', 'NotasController@alterarConfig')->name('alterar_config.nota');
    Route::get('remover_material_nota/{id}', 'NotasController@removerNotaMaterial')->name('remover_material.nota');
    Route::post('adicionar_material_nota', 'NotasController@adicionarMaterial')->name('adicionar_material.nota');
    Route::get('nota_materiais_edit', 'NotasController@notaMateriaisEdit')->name('materiais_edit.nota');

    Route::post('nota/update', 'NotasController@update')->name('update.nota');
    Route::get('nota/consulta', 'NotasController@consultar')->name('consult.nota');
    Route::get('nota/remover/{id}', 'NotasController@remover')->name('remover.nota');

    Route::get('cadastrar_unidade/{id}', 'UnidadeController@cadastrar')->name('cadastrar.unidade');
    Route::get('unidades/{id}', 'UnidadeController@index')->name('index.unidade');
    Route::get('unidades/edit', 'UnidadeController@editar')->name('index_edit.unidade');
    Route::get('unidade_edit/{id}', 'UnidadeController@edit')->name('edit.unidade');
    Route::get('unidade_remove/{id}', 'UnidadeController@remover')->name('remover.unidade');
    Route::post('criar_unidade', 'UnidadeController@criar')->name('criar.unidade');
    Route::post('alterar_unidade', 'UnidadeController@alterar')->name('alterar.unidade');

    Route::get('solicitar_material', 'SolicitacaoController@show')->name('solicitar.material');
    Route::post('adicionar_material', 'SolicitacaoController@store')->name('add.material');

    Route::get('recibo', 'SolicitacaoController@gerarRecibo')->name('solicitar.recibo');
});


Route::middleware(['auth', 'verified', 'CheckCargoAdminDiretoria'])->group(function () {
    Route::get('relatorio.materiais', 'RelatorioController@relatorio_escolha')->name('relatorio.materiais');
    Route::POST('relatorio.materiais', 'RelatorioController@gerarRelatorioMateriais')->name('relatorio.materiais');
});

Route::middleware(['auth', 'verified', 'CheckCargoAdminTerceirizado'])->group(function () {
    Route::get('entrega_materiais', 'SolicitacaoController@listSolicitacoesAprovadas')->name('entrega.materiais');
    Route::POST('entrega_materiais', 'SolicitacaoController@checkEntregarMateriais')->name('entrega.materiais');
    Route::get('entregar_todos_materiais', 'SolicitacaoController@entregarTodosMateriais')->name('entrega.todos.materiais');
    Route::get('consultarDeposito', 'DepositoController@consultarDepositoView')->name('deposito.consultarDeposito');
    Route::resource('material', 'MaterialController')->except(['show']);
    Route::get('solicitacoes_admin', 'SolicitacaoController@listTodasSolicitacoes')->name('solicitacoe.admin');
    Route::get('get_estoques/{setor_id}', 'DepositoController@getEstoques')->name('deposito.getEstoque');
    Route::get('get_materiais/{unidade_id}', 'SolicitacaoController@getMateriais')->name('setor.getMateriais');
});

Route::middleware('auth', 'verified')->group(function () {
    Route::resource('usuario', 'UsuarioController');
    Route::get('usuario/{id}/edit_perfil', 'UsuarioController@edit_perfil')->name('usuario.edit_perfil');
    Route::get('usuario/{id}/edit_senha', 'UsuarioController@edit_senha')->name('usuario.edit_senha');
    Route::get('usuario/{id}/remover', 'UsuarioController@destroy')->name('usuario.destroy');
    Route::get('usuario/{id}/restaurar', 'UsuarioController@restore')->name('usuario.restore');
    Route::put('usuario/update_perfil/{id}', 'UsuarioController@update_perfil')->name('usuario.update_perfil');
    Route::put('usuario/update_senha/{id}', 'UsuarioController@update_senha')->name('usuario.update_senha');

    Route::get('/', function () {
        return view('home');
    })->name('home');

    Route::get('solicitante_solicitacao/{id}', 'SolicitacaoController@getSolicitanteSolicitacao')->name('solicitante.solicitacao');
    Route::get('itens_solicitacao_admin/{id}', 'SolicitacaoController@getItemSolicitacaoAdmin')->name('itens.solicitacao.admin');

    Route::post('ajaxAdicionarEmitente', 'NotasController@adicionarEmitente')->name('adicionar_emitente.nota');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
