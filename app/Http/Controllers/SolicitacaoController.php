<?php

namespace App\Http\Controllers;

use App\Estoque;
use App\HistoricoStatus;
use App\ItemSolicitacao;
use App\Material;
use App\Notificacao;
use App\Recibo;
use App\Setor;
use App\Solicitacao;
use App\Unidade;
use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade as PDF;

class SolicitacaoController extends Controller
{
    public function show()
    {
        $estoques = Estoque::where('deposito_id', 1)->get();
        $materiais = [];
        $unidades = Unidade::all();
        foreach ($estoques as $estoque) {
            array_push($materiais, Material::find($estoque->material_id));
        }

        return view('solicitacao.solicita_material', ['materiais' => $materiais, 'unidades' => $unidades, 'estoques' => $estoques]);
    }

    public function store(Request $request)
    {
        $materiais = explode(',', $request->dataTableMaterial);
        $quantidades = explode(',', $request->dataTableQuantidade);
        $unidades = explode(',', $request->dataTableUnidade);

        $materiaisCheck = true;

        for ($i = 0; $i < count($materiais); ++$i) {
            if (empty($materiais[$i]) || empty($quantidades[$i]) || !is_numeric($materiais[$i]) || !is_numeric($quantidades[$i])) {
                $materiaisCheck = false;
                break;
            }

            if ((is_numeric($materiais[$i]) && intval($materiais[$i]) < 0 || strpos($materiais[$i], '.') || strpos($materiais[$i], ','))
                || (is_numeric($quantidades[$i]) && intval($quantidades[$i]) < 0 || strpos($quantidades[$i], '.') || strpos($quantidades[$i], ','))) {
                $materiaisCheck = false;
                break;
            }
            $estoque = Estoque::where('material_id', '=', $materiais[$i])->first();
            if ($quantidades[$i] > $estoque->quantidade) {
                $material = Material::find($materiais[$i]);
                return redirect()->back()->withErrors('Você solicitou uma quantidade do material ' . $material->nome
                    . ' que não possui em estoque. Quantidade em Estoque: ' . $estoque->quantidade . ' Quantidade Solicitada: ' . $quantidades[$i]);
            }
        }

        if (!$materiaisCheck) {
            return redirect()->back()->withErrors('Informe valores válidos para o(s) material(is) e sua(s) quantidade(s)');
        }

        $solicitacao = new Solicitacao();
        $solicitacao->usuario_id = Auth::user()->id;
        $solicitacao->unidade_id = $unidades[0];
        $usuario = Usuario::find(Auth::user()->id);

        $solicitacao->save();

        $historicoStatus = new HistoricoStatus();
        $historicoStatus->status = 'Aprovado';
        $historicoStatus->solicitacao_id = $solicitacao->id;
        $historicoStatus->data_aprovado = now();
        $historicoStatus->save();

        for ($i = 0; $i < count($materiais); ++$i) {
            $itemSolicitacao = new ItemSolicitacao();
            $itemSolicitacao->quantidade_solicitada = $quantidades[$i];
            $itemSolicitacao->quantidade_aprovada = $quantidades[$i];
            $itemSolicitacao->material_id = $materiais[$i];
            $itemSolicitacao->solicitacao_id = $solicitacao->id;
            $itemSolicitacao->save();
        }

        return redirect()->back()->with('success', 'Solicitação feita com sucesso!');
    }

    public function listSolicitacoesAprovadas()
    {
        $consulta = DB::select('select status.status, status.created_at, status.solicitacao_id, u.nome
            from historico_statuses status, unidades u, solicitacaos soli
            where status.data_aprovado IS NOT NULL and status.data_finalizado IS NULL and status.solicitacao_id = soli.id
            and soli.unidade_id = u.id order by status.id desc');


        $solicitacoesID = array_column($consulta, 'solicitacao_id');
        $materiaisPreview = [];

        if (!empty($solicitacoesID)) {
            $materiaisPreview = $this->getMateriaisPreview($solicitacoesID);
        }

        return view('solicitacao.entrega_materiais', [
            'dados' => $consulta, 'materiaisPreview' => $materiaisPreview,
        ]);
    }

    public function listTodasSolicitacoes()
    {
        $consulta = DB::select('select status.status, status.created_at, status.solicitacao_id, u.nome
            from historico_statuses status, unidades u, solicitacaos soli
            where status.data_finalizado IS NOT NULL and status.solicitacao_id = soli.id
            and soli.unidade_id = u.id order by status.id desc');

        $solicitacoesID = array_column($consulta, 'solicitacao_id');
        $materiaisPreview = [];

        if (!empty($solicitacoesID)) {
            $materiaisPreview = $this->getMateriaisPreview($solicitacoesID);
        }

        return view('solicitacao.todas_solicitacao', [
            'dados' => $consulta, 'materiaisPreview' => $materiaisPreview,
        ]);
    }

    public function checkEntregarMateriais(Request $request)
    {
        if ('aprovar_entrega' == $request->action) {
            return $this->entregarMateriais($request->solicitacaoID);
        }
        if ('cancelar_entrega' == $request->action) {
            return $this->cancelarEntregaMataeriais($request->solicitacaoID);
        }
    }

    public function gerarRecibo($id)
    {
        $recibo = Recibo::find($id);
        $solicitante = $recibo->unidade->nome;
        $itens = explode('#', $recibo->itens);

        $dia = $recibo->created_at->format('d');
        $ano = $recibo->created_at->format('Y');

        if ($recibo->created_at->format('m') == '01') {
            $mes = 'Janeiro';
        } elseif ($recibo->created_at->format('m') == '02') {
            $mes = 'Fevereiro';
        } elseif ($recibo->created_at->format('m') == '03') {
            $mes = 'Março';
        } elseif ($recibo->created_at->format('m') == '04') {
            $mes = 'Abril';
        } elseif ($recibo->created_at->format('m') == '05') {
            $mes = 'Maio';
        } elseif ($recibo->created_at->format('m') == '06') {
            $mes = 'Junho';
        } elseif ($recibo->created_at->format('m') == '07') {
            $mes = 'Julho';
        } elseif ($recibo->created_at->format('m') == '08') {
            $mes = 'Agosto';
        } elseif ($recibo->created_at->format('m') == '09') {
            $mes = 'Setembro';
        } elseif ($recibo->created_at->format('m') == '10') {
            $mes = 'Outubro';
        } elseif ($recibo->created_at->format('m') == '11') {
            $mes = 'Novembro';
        } elseif ($recibo->created_at->format('m') == '12') {
            $mes = 'Dezembro';
        }

        $pdf = PDF::loadView('solicitacao.recibo', compact('itens', 'dia', 'mes', 'ano','solicitante'));
        $nomePDF = 'Relatório_Materiais_Mais_Movimentados_Solicitação_Semana.pdf';
        return $pdf->setPaper('a4')->stream($nomePDF);
    }

    public function entregarTodosMateriais()
    {
        $historicos = HistoricoStatus::where('status', 'Aprovado')->get();

        $flag = 0;
        $errorMessage = [];
        foreach ($historicos as $historico) {
            $itens = ItemSolicitacao::where('solicitacao_id', '=', $historico->solicitacao_id)->where('quantidade_aprovada', '!=', null)->get();
            $materiaisID = array_column($itens->toArray(), 'material_id');
            $materiaisNome = Material::select('nome')->whereIn('id', $materiaisID)->get();
            $quantAprovadas = array_column($itens->toArray(), 'quantidade_aprovada');

            $estoque = Estoque::wherein('material_id', $materiaisID)->where('deposito_id', 1)->orderBy('material_id', 'asc')->get();

            $checkQuant = true;

            foreach ($itens as $item) {
                $estoqueItem = Estoque::where('material_id', $item->material_id)->where('deposito_id', 1)->first();
                $materialNome = Material::where('id', $item->material_id)->first();

                if (($estoqueItem->quantidade - $item->quantidade_aprovada) < 0) {
                    $checkQuant = false;
                    $message = $materialNome->nome . ' quantidade disponível(' . $estoqueItem->quantidade . ')' . ' - quantidade aprovada(' . $item->quantidade_aprovada . ')';
                    array_push($errorMessage, $message);
                }
            }

            if ($checkQuant) {
                $materiais = Material::all();
                $usuarios = Usuario::all();
                $flag = 1;

                for ($i = 0; $i < count($materiaisID); ++$i) {
                    DB::update('update estoques set quantidade = quantidade - ? where material_id = ? and deposito_id = 1', [$quantAprovadas[$i], $materiaisID[$i]]);

                    $material = $materiais->find($materiaisID[$i]);
                    $estoque = DB::table('estoques')->where('material_id', '=', $materiaisID[$i])->first();
                    if (($estoque->quantidade - $quantAprovadas[$i]) <= $material->quantidade_minima) {
                        foreach ($usuarios as $usuario) {
                            if ($usuario->cargo_id == 2) {
                                \App\Jobs\emailMaterialEsgotando::dispatch($usuario, $material);

                                $mensagem = $material->nome . ' em estado critico.';
                                $notificacao = new Notificacao();
                                $notificacao->mensagem = $mensagem;
                                $notificacao->usuario_id = $usuario->id;
                                $notificacao->material_id = $material->id;
                                $notificacao->material_quant = $estoque->quantidade;
                                $notificacao->visto = false;
                                $notificacao->save();
                            }
                        }
                    }
                }

                //Criação do recibo
                $lista = '';
                $solicitacao = Solicitacao::find($historico->solicitacao_id);
                $itens = ItemSolicitacao::where('solicitacao_id', $historico->solicitacao_id)->get();
                foreach ($itens as $item) {
                    $material = Material::find($item->material_id);
                    $lista = $lista . $item->quantidade_aprovada . ' UNID ' . $material->nome . '#';

                }
                $recibo = new Recibo();
                $recibo->unidade_id = $solicitacao->unidade_id;
                $recibo->itens = $lista;
                $recibo->save();
                // Fim

                DB::update(
                    'update historico_statuses set status = ?, data_finalizado = now() where solicitacao_id = ?',
                    ['Entregue', $historico->solicitacao_id]
                );
            }
        }
        if ($flag == 0) {
            return redirect()->back()->with('error', $errorMessage);
        }
        return redirect()->back()->with(['success' => 'Material(is) entregue(s) com sucesso!']);
    }

    public function entregarMateriais($id)
    {
        $itens = ItemSolicitacao::where('solicitacao_id', '=', $id)->where('quantidade_aprovada', '!=', null)->get();
        $materiaisID = array_column($itens->toArray(), 'material_id');
        $materiaisNome = Material::select('nome')->whereIn('id', $materiaisID)->get();
        $quantAprovadas = array_column($itens->toArray(), 'quantidade_aprovada');

        $estoque = Estoque::wherein('material_id', $materiaisID)->where('deposito_id', 1)->orderBy('material_id', 'asc')->get();

        $checkQuant = true;
        $errorMessage = [];

        foreach ($itens as $item) {
            $estoqueItem = Estoque::where('material_id', $item->material_id)->where('deposito_id', 1)->first();
            $materialNome = Material::where('id', $item->material_id)->first();

            if (($estoqueItem->quantidade - $item->quantidade_aprovada) < 0) {
                $checkQuant = false;
                $message = $materialNome->nome . ' quantidade disponível(' . $estoqueItem->quantidade . ')' . ' - quantidade aprovada(' . $item->quantidade_aprovada . ')';
                array_push($errorMessage, $message);
            }
        }

        if ($checkQuant) {
            $materiais = Material::all();
            $usuarios = Usuario::all();

            for ($i = 0; $i < count($materiaisID); ++$i) {
                DB::update('update estoques set quantidade = quantidade - ? where material_id = ? and deposito_id = 1', [$quantAprovadas[$i], $materiaisID[$i]]);

                $material = $materiais->find($materiaisID[$i]);
                $estoque = DB::table('estoques')->where('material_id', '=', $materiaisID[$i])->first();
                if (($estoque->quantidade - $quantAprovadas[$i]) <= $material->quantidade_minima) {
                    foreach ($usuarios as $usuario) {
                        if ($usuario->cargo_id == 2) {
                            \App\Jobs\emailMaterialEsgotando::dispatch($usuario, $material);

                            $mensagem = $material->nome . ' em estado critico.';
                            $notificacao = new Notificacao();
                            $notificacao->mensagem = $mensagem;
                            $notificacao->usuario_id = $usuario->id;
                            $notificacao->material_id = $material->id;
                            $notificacao->material_quant = $estoque->quantidade;
                            $notificacao->visto = false;
                            $notificacao->save();
                        }
                    }
                }
            }

            //Criação do recibo
            $lista = '';
            $solicitacao = Solicitacao::find($id);
            $itens = ItemSolicitacao::where('solicitacao_id', $id)->get();
            foreach ($itens as $item) {
                $material = Material::find($item->material_id);
                $lista = $lista . $item->quantidade_aprovada . ' UNID ' . $material->nome . '#';

            }
            $recibo = new Recibo();
            $recibo->unidade_id = $solicitacao->unidade_id;
            $recibo->itens = $lista;
            $recibo->save();
            // Fim

            DB::update(
                'update historico_statuses set status = ?, data_finalizado = now() where solicitacao_id = ?',
                ['Entregue', $id]
            );

            return redirect()->back()->with('success', 'Material(is) entregue(s) com sucesso!');
        }
        return redirect()->back()->with('error', $errorMessage);
    }

    public function cancelarEntregaMataeriais($id)
    {
        DB::update(
            'update historico_statuses set status = ?, data_finalizado = now() where solicitacao_id = ?',
            ['Cancelado', $id]
        );

        return redirect()->back()->with('success', 'Material(is) cancelado(s) com sucesso!');
    }

    public function getItemSolicitacaoAdmin($id)
    {
        if (session()->exists('itemSolicitacoes')) {
            session()->forget('itemSolicitacoes');
        }

        $consulta = DB::select('select item.quantidade_solicitada, item.material_id, mat.nome, mat.corredor, mat.prateleira, mat.coluna, mat.descricao, mat.unidade, item.id, item.quantidade_solicitada, est.quantidade
            from item_solicitacaos item, materials mat, estoques est where item.solicitacao_id = ? and mat.id = item.material_id and est.material_id = item.material_id and est.deposito_id = 1', [$id]);

        session(['itemSolicitacoes' => $consulta]);

        return json_encode($consulta);


    }

    public function getSolicitanteSolicitacao($id)
    {
        $consulta = DB::select('select uni.nome from solicitacaos soli, unidades uni where soli.id = ? and uni.id = soli.unidade_id', [$id]);

        return json_encode($consulta);
    }

    public function getMateriais($unidade_id)
    {
        $unidade = Unidade::find($unidade_id);

        $materiais = DB::table('materials')
            ->join('estoques', 'materials.id', '=', 'estoques.material_id')
            ->where('setor_id','=', $unidade->setor_id)->get();


        return response()->json($materiais);
    }

    public function getMateriaisPreview($solicitacoes_id)
    {
        $materiaisIDItem = ItemSolicitacao::select('material_id', 'solicitacao_id')->whereIn('solicitacao_id', $solicitacoes_id)->orderBy('solicitacao_id', 'desc')->get();
        $itensSolicitacaoID = array_values(array_unique(array_column($materiaisIDItem->toArray(), 'solicitacao_id')));

        $materiais = DB::select('select item.material_id, item.solicitacao_id, mat.nome
            from item_solicitacaos item, materials mat
            where item.solicitacao_id in (' . implode(',', $solicitacoes_id) . ') and item.material_id = mat.id');

        $materiaisPreview = [];
        $auxCountMaterial = 0;

        for ($i = 0; $i < count($itensSolicitacaoID); ++$i) {
            for ($b = 0; $b < count($materiais); ++$b) {
                if ($auxCountMaterial > 2) {
                    break;
                }
                if ($itensSolicitacaoID[$i] == $materiais[$b]->solicitacao_id) {
                    if ($auxCountMaterial > 0) {
                        $materiaisPreview[$i] .= ', ' . $materiais[$b]->nome;
                    } else {
                        array_push($materiaisPreview, $materiais[$b]->nome);
                    }
                    ++$auxCountMaterial;
                }
            }
            $auxCountMaterial = 0;
        }

        return $materiaisPreview;
    }

}
