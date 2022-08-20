<?php

namespace App\Http\Controllers;

use App\Deposito;
use App\Estoque;
use App\Setor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DepositoController extends Controller
{
    public function index()
    {
        return view('deposito/deposito_index', ['depositos' => Deposito::all(), 'estoques' => Estoque::all()]);
    }

    public function consultarDepositoView()
    {
        $setores = Setor::all();
        $estoques = Estoque::all();

        return view('deposito.deposito_consult', compact('setores', 'estoques'));
    }

    public function getEstoques($setor_id)
    {
        $estoques = DB::select('Select mat.nome, e.quantidade from estoques e, Materials mat where e.setor_id = ? and mat.id = e.material_id', [$setor_id]);

        return response()->json($estoques);
    }

    public function create()
    {
        return view('deposito/deposito_create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Deposito::$rules, Deposito::$messages)->validate();

        $data = [
            'nome' => $request->nome,
            'codigo' => $request->codigo,
        ];

        $deposito = Deposito::create($data);
        $deposito->save();

        return redirect(route('deposito.index'));
    }

    public function show($id)
    {
        return view('deposito/deposito_show', ['deposito' => Deposito::find($id)]);
    }

    public function edit($id)
    {
        return view('deposito/deposito_edit', ['deposito' => Deposito::find($id)]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), Deposito::$rules, Deposito::$messages)->validate();
        $deposito = Deposito::find($id);

        $data = [
            'nome' => $request->nome,
            'codigo' => $request->codigo,
        ];

        $deposito->fill($data)->save();

        return redirect(route('deposito.index'))->with('sucess', 'Deposito alterado com sucesso!');
    }

    public function destroy($id)
    {
        $estoques = Estoque::all()->where('deposito_id', '=', $id)->first();
        if (empty($estoques)) {
            $deposito = Deposito::all()->find($id);
            $deposito->delete();

            return redirect(route('deposito.index'))->with('sucess', 'Desposito removido com sucesso!');
        }

        return redirect()->back()->with('fail', 'Deposito não vazio, não é possivel remover!');
    }
}
