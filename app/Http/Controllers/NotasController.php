<?php

namespace App\Http\Controllers;

use App\config_nota_fiscal;
use App\Emitente;
use App\Material;
use App\MaterialNotas;
use App\NotaFiscal;
use App\OrdemFornecimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\Echo_;

class NotasController extends Controller
{

    public function index($id){
        $notas = NotaFiscal::where('ordem_fornecimento_id', $id)->get();
        $ordem = OrdemFornecimento::find($id);
        return view('notas.notas_index_edit', compact('notas','ordem'));
    }

    public function edit($id)
    {
        $config = config_nota_fiscal::all()->first();
        $emitentes = Emitente::all();
        $nota = NotaFiscal::find($id);
        $ordem = OrdemFornecimento::find($nota->ordem_fornecimento->id);
        return view('notas.notas_edit', ['nota' => $nota,'config' => $config,'emitentes' => $emitentes, 'ordem' => $ordem]);
    }

    public function update(Request $request)
    {
        $nota = NotaFiscal::find($request->nota_id);
        $nota->numero = $request->numero;
        $nota->serie = $request->serie;
        $nota->data_emissao = $request->data_emissao;
        $nota->natureza_operacao = $request->natureza_operacao;
        $nota->emitente_id = $request->emitente_id;
        $nota->update();
        return redirect(route('index.nota', ['id' => $nota->ordem_fornecimento->id]))->with('success', 'Nota Atualizada Com Sucesso!');
    }

    public function consultar(){
        $config = config_nota_fiscal::all()->first();
        $emitentes = Emitente::all();
        return view('notas.notas_consult', ['notas' => NotaFiscal::all(),'config' => $config,'emitentes'=>$emitentes]);
    }

    public function remover($id)
    {
        $nota = NotaFiscal::find($id);
        if($nota->materiais()->count() == 0){
            $nota->delete();
            return redirect()->back()->with('success', 'Nota Removida Com Sucesso!');
        }
        return redirect()->back()->with('fail', 'Nota possui materiais associados!');
    }

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

        return redirect(route('config.nota'))->with('success', 'Configurações de Notas Fiscais Atualizadas');
    }


    public function cadastrar($id)
    {
        $config = config_nota_fiscal::all()->first();
        $emitentes = Emitente::all();
        $ordem = OrdemFornecimento::find($id);
        return view('notas.notas_create', ['config' => $config, 'emitentes'=>$emitentes, 'ordem'=>$ordem]);

    }

    public function removerNotaMaterial($id)
    {
        $notaMaterial = MaterialNotas::find($id);
        $notaFiscal = NotaFiscal::find($notaMaterial->nota_fiscal_id);
        $material = Material::find($notaMaterial->material_id);
        if ($notaMaterial->quantidade_atual == 0) {
            $notaFiscal->valor_nota -= ($notaMaterial->quantidade_total * $notaMaterial->valor);
            $notaFiscal->update();
            $notaMaterial->delete();
            return redirect()->back()->with('sucess', 'Material Removido Com Sucesso!');
        } else {
            return redirect()->back()->with('fail', 'O Material Já Foi Adicionado Ao Estoque');
        }
    }

    public function create(Request $request)
    {

        $rules = array_slice(NotaFiscal::$rules, 0, 4);
        $messages = array_slice(NotaFiscal::$messages, 0, 10);
        $validator = Validator::make($request->all(), $rules, $messages)->validate();

        $nota = new NotaFiscal();

        $nota->numero = $request->numero;
        $nota->serie = $request->serie;
        $nota->data_emissao = $request->data_emissao;
        $nota->natureza_operacao = $request->natureza_operacao;
        $nota->emitente_id = $request->emitente_id;
        $nota->valor_nota = 0;
        $nota->status = 'Não Concluida';
        $nota->ordem_fornecimento_id = $request->ordem_id;
        $nota->save();
        return redirect(route('materiais_edit.nota', ['nota' => $nota->id]));

    }

    public function adicionarEmitente(Request $request)
    {
        $emitente = new Emitente();
        $emitente->inscricao_estadual = $request->inscricao_estadual;
        $emitente->cnpj = $request->cnpj;
        $emitente->razao_social = $request->razao_social;
        $emitente->save();
        return response()->json(['success'=> 'Emitente Cadastrado com Sucesso!', 'id' => $emitente->id, 'cnpj' => $emitente->cnpj, 'razao_social' => $emitente->razao_social]);

    }

    public function notaMateriaisEdit(Request $request)
    {
        $nota = NotaFiscal::find($request->nota);
        $notaMaterial = MaterialNotas::where('nota_fiscal_id',$nota->id)->pluck('material_id');

        $materiais = Material::whereNotIn('id',$notaMaterial)->get();



        $materiais_nota = MaterialNotas::where('nota_fiscal_id', $nota->id)->get();
        return view('notas.nota_materiais_edit', ['nota' => $nota, 'materiais' => $materiais, 'materiais_nota' => $materiais_nota]);
    }

    public function adicionarMaterial(Request $request)
    {
        $materialNotas = new MaterialNotas();
        $notaFiscal = NotaFiscal::find($request->nota_fiscal_id);

        $materialNotas->nota_fiscal_id = $request->nota_fiscal_id;
        $materialNotas->quantidade = $request->quantidade_total;
        $materialNotas->material_id = $request->material_id;
        $materialNotas->valor = $request->valor;
        $notaFiscal->valor_nota += ($request->quantidade * $request->valor);
        $notaFiscal->update();
        $materialNotas->save();

        return redirect(route('materiais_edit.nota', ['nota' => $request->nota_fiscal_id]))->with('success', 'Material Adicionado Com Sucesso!');
    }

}
