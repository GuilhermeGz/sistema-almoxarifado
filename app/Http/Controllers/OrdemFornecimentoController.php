<?php

namespace App\Http\Controllers;

use App\OrdemFornecimento;
use Illuminate\Http\Request;

class OrdemFornecimentoController extends Controller
{

    public function index(){
        $ordens = OrdemFornecimento::all();
        return view('ordemFornecimento.index', compact('ordens'));
    }

    public function cadastrar(){
        return view('ordemFornecimento.create');
    }

    public function editar($id){
        $ordem = OrdemFornecimento::find($id);
        return view('ordemFornecimento.edit', compact('ordem'));
    }

    public function store(Request $request){
        $ordem = new OrdemFornecimento();
        $ordem->codigo = $request->codigo;
        $ordem->num_contrato = $request->num_contrato;
        $ordem->pregao = $request->pregao;
        $ordem->save();

        return redirect(route('index.ordemFornecimento'))->with('success', 'Ordem de Fornecimento Criada com Sucesso!');
    }

    public function update(Request $request){
        $ordem = OrdemFornecimento::find($request->ordem_id);
        $ordem->codigo = $request->codigo;
        $ordem->num_contrato = $request->num_contrato;
        $ordem->pregao = $request->pregao;
        $ordem->update();

        return redirect(route('index.ordemFornecimento'))->with('success', 'Ordem de Fornecimento Atualizada com Sucesso!');
    }

    public function remover($id){
        $ordem = OrdemFornecimento::find($id);
        $ordem->delete();
        return redirect(route('index.ordemFornecimento'))->with('success', 'Ordem de Fornecimento Deletada com Sucesso!');
    }

}
