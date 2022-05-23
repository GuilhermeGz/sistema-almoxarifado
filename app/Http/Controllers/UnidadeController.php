<?php

namespace App\Http\Controllers;

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
        $unidade->save();

        return redirect(route('index.unidade'))->with('success', 'Unidade Cadastrada com Sucesso!');
    }

    public function index()
    {
        $unidades = Unidade::all()->sortBy('created_at');
        return view('unidade.unidade_consult', ['unidades' => $unidades]);
    }
}
