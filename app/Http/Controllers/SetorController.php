<?php

namespace App\Http\Controllers;

use App\Setor;
use App\Unidade;
use Illuminate\Http\Request;

class SetorController extends Controller
{

    public function index(){
        $setores = Setor::all()->sortBy("id");
        return view('setor.index', compact('setores'));
    }

    public function store(Request $request){
        $setor = new Setor();
        $setor->nome = $request->nome;
        $setor->save();
        return redirect(route('index.setor'))->with('success', 'Setor Criado com Sucesso!');
    }

    public function remover($id)
    {
        $setor = Setor::find($id);
        $unidades = Unidade::where('setor_id', $setor->id)->get();

        if(count($unidades) == 0)
        {
            $setor->delete();
            return redirect()->back()->with('success', 'Setor Removido com Sucesso!');
        } else {
            return redirect()->back()->with('fail', 'Não é possivel remover, o setor unidades cadastradas.');
        }
    }

    public function update(Request $request){
        $setor = Setor::find($request->setor_id);
        $setor->nome = $request->nome;
        $setor->update();
        return redirect()->back()->with('success', 'Setor Editado com Sucesso!');
    }

}
