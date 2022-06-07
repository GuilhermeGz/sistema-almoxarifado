<?php

namespace App\Http\Controllers;

use App\Solicitacao;
use App\Unidade;
use Illuminate\Http\Request;

class UnidadeController extends Controller
{
    public function cadastrar()
    {
        return view('unidade.unidade_create');
    }

    public function criar(Request $request)
    {
        $unidade = new Unidade();
        $unidade->nome = $request->nome;
        $unidade->cep = $request->cep;
        $unidade->endereco = $request->endereco;
        $unidade->bairro = $request->bairro;
        $unidade->nome_coordenador = $request->nome_coordenador;
        $unidade->numero_coordenador = $request->numero_coordenador;
        $unidade->nome_enfermeira = $request->nome_enfermeira;
        $unidade->numero_enfermeira = $request->numero_enfermeira;
        $unidade->save();

        return redirect(route('index.unidade'))->with('success', 'Unidade Cadastrada com Sucesso!');
    }

    public function index()
    {
        $unidades = Unidade::all()->sortBy('created_at');
        return view('unidade.unidade_consult', ['unidades' => $unidades]);
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
        $unidade->nome_coordenador = $request->nome_coordenador;
        $unidade->numero_coordenador = $request->numero_coordenador;
        $unidade->nome_enfermeira = $request->nome_enfermeira;
        $unidade->numero_enfermeira = $request->numero_enfermeira;
        $unidade->update();
        return redirect(route('index_edit.unidade'))->with('success', 'Unidade Alterada com Sucesso!');
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