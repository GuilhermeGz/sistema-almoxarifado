<?php

namespace App\Http\Controllers;

use App\config_nota_fiscal;
use App\Material;
use App\MaterialNotas;
use App\notaFiscal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class NotasController extends Controller
{

    public function configurar()
    {

        $config = config_nota_fiscal::all()->first();
        return view('notas.config_notas', ['config' => $config]);
    }

    public function alterarConfig(Request $request)
    {

        $rules = array_slice(config_nota_fiscal::$rules, 0, 4);
        $messages = array_slice(config_nota_fiscal::$messages, 0, 10);
        $validator = Validator::make($request->all(), $rules, $messages)->validate();

        $config = config_nota_fiscal::all()->first();
        if (isset($config)) {
            $config->inscricao_estadual = $request->inscricao_estadual;
            $config->nome = $request->nome;
            $config->fone = $request->fone;
            $config->estado = $request->estado;
            $config->cep = $request->cep;
            $config->endereco = $request->endereco;
            $config->bairro = $request->bairro;
            $config->municipio = $request->municipio;
            $config->cnpj = $request->cnpj;
            $config->update();
        } else {
            $config = new config_nota_fiscal();
            $config->inscricao_estadual = $request->inscricao_estadual;
            $config->nome = $request->nome;
            $config->fone = $request->fone;
            $config->estado = $request->estado;
            $config->cep = $request->cep;
            $config->endereco = $request->endereco;
            $config->bairro = $request->bairro;
            $config->municipio = $request->municipio;
            $config->cnpj = $request->cnpj;
            $config->save();
        }

        return redirect(route('config.nota'))->with('sucess', 'Configurações de Notas Fiscais Atualizadas');
    }


    public function cadastrar()
    {
        $config = config_nota_fiscal::all()->first();
        return view('notas.notas_create', ['config' => $config]);

    }

    public function removerNotaMaterial($id)
    {
        $notaMaterial = MaterialNotas::find($id);
        $notaMaterial->delete();
        return redirect()->back()->with('sucess', 'Material Removido Com Sucesso!');
    }

    public function create(Request $request)
    {

        $nota = new NotaFiscal();

        $nota->cnpj = $request->cnpj;
        $nota->valor_nota = $request->valor_nota;
        $nota->save();
        return redirect(route('materiais_edit.nota', ['nota' => $nota->id]));


    }

    public function notaMateriaisEdit(Request $request)
    {
        $materiais = Material::all();
        $nota = NotaFiscal::find($request->nota);

        $materiais_nota = MaterialNotas::where('nota_fiscal_id', $nota->id)->get();
        return view('notas.nota_materiais_edit', ['nota' => $nota, 'materiais' => $materiais, 'materiais_nota' => $materiais_nota]);
    }

    public function adicionarMaterial(Request $request)
    {
        $materialNotas = new MaterialNotas();

        $materialNotas->nota_fiscal_id = $request->nota_fiscal_id;
        $materialNotas->quantidade_total = $request->quantidade_total;
        $materialNotas->material_id = $request->material_id;
        $materialNotas->quantidade_atual = 0;
        $materialNotas->status = false;
        $materialNotas->save();

        return redirect(route('materiais_edit.nota', ['nota' => $request->nota_fiscal_id]))->with('sucess', 'Material Adicionado Com Sucesso!');
    }

}