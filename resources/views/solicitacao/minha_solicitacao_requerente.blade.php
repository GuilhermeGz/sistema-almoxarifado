@extends('templates.principal')

@section('title') Minhas Solicitações @endsection

@section('content')
    <div style="border-bottom: #949494 2px solid; padding-bottom: 5px; margin-bottom: 10px">
        <h2>MINHAS SOLICITAÇÕES</h2>
    </div>

    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <strong>{{session('success')}}</strong>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @if(session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>{{session('error')}}</strong>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <h6>Clique em uma linha na tabela para visualizar uma amostra dos materiais da solicitação.</h6>
    <h6>Para ver todos os materiais e aprovar/cancelar uma entrega clique em uma linha da tabela subsequente.</h6>

    <table id="tableSolicitacoes" class="table table-hover table-responsive-md" style="margin-top: 10px;">
        <thead style="background-color: #151631; color: white; border-radius: 15px">
        <tr>
            <th scope="col" style="padding-left: 10px">Material</th>
            <th scope="col" style="text-align: center">Situação</th>
            <th scope="col" style="text-align: center">Data</th>
            <th scope="col" style="text-align: center">Ações</th>
        </tr>
        </thead>
        <tbody>
        @for ($i = 0; $i < count($status); $i++)
            <tr data-id="{{ $status[$i]->solicitacao_id }}" style="cursor: pointer">
                <td class="expandeOption">{{$materiaisPreview[$i]}}...</td>
                <td class="expandeOption" style="text-align: center">
                    @if ($status[$i]->status == "Aguardando Analise")
                        <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-clock-history" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z"/>
                            <path fill-rule="evenodd" d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z"/>
                            <path fill-rule="evenodd" d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"/>
                        </svg>
                    @endif
                    @if ($status[$i]->status == "Entregue" || $status[$i]->status == "Aprovado")
                        <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-check-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path fill-rule="evenodd" d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z"/>
                        </svg>
                    @endif
                    @if ($status[$i]->status == "Cancelado" || $status[$i]->status == "Negado")
                        <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-x-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path fill-rule="evenodd" d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                        </svg>
                    @endif
                    @if ($status[$i]->status == "Aprovado Parcialmente")
                        <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-check2-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M15.354 2.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L8 9.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                            <path fill-rule="evenodd" d="M8 2.5A5.5 5.5 0 1 0 13.5 8a.5.5 0 0 1 1 0 6.5 6.5 0 1 1-3.25-5.63.5.5 0 1 1-.5.865A5.472 5.472 0 0 0 8 2.5z"/>
                        </svg>
                    @endif
                    {{ $status[$i]->status }}
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
                    </svg>
                </td>
                <td class="expandeOption" style="text-align: center">{{ date('d/m/Y',  strtotime($status[$i]->created_at))}}</td>
                <td style="text-align: center">
                    <div class="dropdown">
                        @if ($status[$i]->status != "Cancelado" && $status[$i]->status != "Entregue" && $status[$i]->status != "Negado")
                            <button class="btn btn-secondary dropdown" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                ⋮
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a type="button" class="dropdown-item" onclick="if(confirm('Tem certeza que deseja cancelar a solicitação?')) location.href='{{ route('cancelar.solicitacao', $status[$i]->solicitacao_id) }}'">Cancelar</a>
                            </div>
                        @endif
                    </div>
                </td>
            </tr>
        @endfor
        </tbody>
    </table>

    <div class="modal fade" id="detalhesSolicitacao" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel" style="color:#151631">Solicitação - <span id="numSolicitacao"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="overlay">
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border text-primary" style="width: 5rem; height: 5rem" role="status"></div>
                        </div>
                    </div>
                    <div id="modalBody" style="display: none">
                        <table id="tableItens" class="table table-hover table-responsive-md" style="margin-top: 10px">
                            <thead style="background-color: #151631; color: white; border-radius: 15px">
                            <tr>
                                <th class="align-middle" scope="col">Material</th>
                                <th class="align-middle" scope="col">Descrição</th>
                                <th class="align-middle" scope="col" style="text-align: center; width: 10%">Qtd. Solicitada</th>
                                <th class="align-middle" scope="col" style="text-align: center; width: 10%">Qtd. Aprovada</th>
                            </tr>
                            </thead>
                            <tbody id="listaItens"></tbody>
                        </table>
                        <div id="observacaoRequerente">
                            <label for="textObservacaoRequerente"><strong>Observações do Requerente:</strong></label>
                            <textarea class="form-control" name="observacaoRequerente" id="textObservacaoRequerente" cols="30" rows="3" readonly></textarea>
                        </div>
                        <div id="observacaoAdmin">
                            <label for="textObservacaoAdmin"><strong>Observações do Administrador:</strong></label>
                            <textarea class="form-control" name="observacaoAdmin" id="textObservacaoAdmin" cols="30" rows="3" readonly></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="{{asset('js/solicitacoes/solicitacao_requerente.js')}}"></script>
