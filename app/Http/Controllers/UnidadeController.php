<?php

namespace App\Http\Controllers;

use App\Recibo;
use App\Setor;
use App\Solicitacao;
use App\Unidade;
use Illuminate\Http\Request;

class UnidadeController extends Controller
{
    public function cadastrar($id)
    {
        $setor = Setor::find($id);
        return view('unidade.unidade_create',compact('setor'));
    }

    public function listarRecibos($id){
        $recibos = Recibo::where('unidade_id',$id)->get();
        return view('recibo.index', ['recibos' => $recibos]);
    }

    public function criar(Request $request)
    {
        $unidade = new Unidade();
        $unidade->nome = $request->nome;
        $unidade->cep = $request->cep;
        $unidade->endereco = $request->endereco;
        $unidade->bairro = $request->bairro;
        $unidade->setor_id = $request->setor;

        $unidade->save();

        return redirect(route('index.unidade',['id' => $request->setor]))->with('success', 'Unidade Cadastrada com Sucesso!');
    }

    public function index($id)
    {
        $unidades = Unidade::where('setor_id',$id)->get()->sortBy('nome');
        $setor = Setor::find($id);
        return view('unidade.unidade_consult', compact('unidades','setor'));
    }

    public function editar()
    {
        $unidades = Unidade::all()->sortBy('created_at');
        return view('unidade.unidade_index_edit', ['unidades' => $unidades]);
    }

    public function edit($id)
    {
        $unidade = Unidade::find($id);
        return view('unidade.unidade_edit', ['unidade' => $unidade]);
    }

    public function alterar(Request $request)
    {
        $unidade = Unidade::find($request->unidade_id);
        $unidade->nome = $request->nome;
        $unidade->cep = $request->cep;
        $unidade->endereco = $request->endereco;
        $unidade->bairro = $request->bairro;
        $unidade->update();
        return redirect(route('index.unidade', ['id' => $unidade->setor->id]))->with('success', 'Unidade Alterada com Sucesso!');
    }

    public function remover($id)
    {
        $unidade = Unidade::find($id);
        $solicitacaos = Solicitacao::where('unidade_id', $unidade->id)->get();

        if(count($solicitacaos) == 0)
        {
            $unidade->delete();
            return redirect()->back()->with('success', 'Unidade Removida com Sucesso!');
        } else {
            return redirect()->back()->with('fail', 'Não é possivel remover, a unidade já possui solicitações.');
        }
    }

}
