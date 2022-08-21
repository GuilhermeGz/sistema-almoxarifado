@extends('templates.principal')

@section('title')
    Ordem Fornecimento
@endsection

@section('content')

    <div class="row" style="border-bottom: #949494 2px solid; padding-bottom: 5px; margin-bottom: 10px">
        <div class="col-md-12">
            <h2>Ordens de Fornecimento Cadastradas</h2>
        </div>
    </div>

    @if(session()->has('fail'))
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>{{session('fail')}}</strong>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @elseif(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <strong>{{session('success')}}</strong>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <table id="tableOrdemIndex" class="table table-hover table-responsive-md">
        <thead style="background-color: #151631; color: white; border-radius: 15px">
        <tr>
            <th class="align-middle" scope="col" style="padding-left: 10px">Código</th>
            <th class="align-middle" scope="col" style="padding-left: 10px">Número do Contrato</th>
            <th class="align-middle" scope="col" style="padding-left: 10px">Pregão</th>
            <th class="align-middle" scope="col" style="text-align: center; width: 10%">Ações</th>
        </tr>
        </thead>
        <tbody>

        @forelse($ordens as $ordem)
            <tr>
                <td class="text-left" style="text-align: center"> {{ $ordem->codigo }} </td>
                <td class="text-left" style="text-align: center"> {{ $ordem->num_contrato }} </td>
                <td class="text-left" style="text-align: center"> {{ $ordem->pregao }} </td>
                <td class="text-left" style="text-align: center">
                    <div class="row">
                        <div class="col-md-4">
                            <a type="button" href="{{route('index.nota', ['id' => $ordem->id])}}" style="color: #212529" title="Notas Fiscais"><i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 23px"></i></a>
                        </div>
                        <div class="col-md-4">
                            <a type="button" href="{{route('editar.ordemFornecimento', ['id' => $ordem->id])}}" style="color: #212529" title="Editar"><i class="fa-solid fa-pen-to-square" style="font-size: 23px"></i></a>
                        </div>
                        <div class="col-md-4">
                            <a type="button" onclick="if(confirm('Tem certeza que deseja Remover a ordem de fornecimento {{$ordem->codigo}}?')) location.href='{{route('remover.ordemFornecimento', ['id' => $ordem->id])}}'" title="Remover"><i class="fa-solid fa-trash-can" style="font-size: 23px"></i></a>
                        </div>
                    </div>
                </td>
            </tr>

            <div class="modal fade" id="setorEditModal{{$ordem->id}}" tabindex="-1" role="dialog" aria-labelledby="setorEditModal{{$ordem->id}}" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-center" id="exampleModalLabel" style="font-weight: bolder">Editar Setor</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" action="{{ route('update.setor') }}">
                            @csrf
                            <input type="hidden" name="setor_id" value="{{$ordem->id}}">
                            <div class="modal-body">
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="nome_setor">Nome<span style="color: red">*</span></label>
                                        <input class="form-control" id="nome_setor" name="nome" value="{{$ordem->nome}}" placeholder="Digite o nome do Setor">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-danger" data-dismiss="modal" aria-label="Close">Cancelar</button>
                                <button type="submit" class="btn btn-success" id="submit-setor">Alterar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <td colspan="10">Sem ordens de fornecimento cadastradas ainda</td>
        @endempty
        </tbody>
    </table>

    <div class="modal fade" id="setorModal" tabindex="-1" role="dialog" aria-labelledby="setorModal" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalLabel" style="font-weight: bolder">Cadastrar Setor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('store.setor') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="nome_setor">Nome<span style="color: red">*</span></label>
                                <input class="form-control" id="nome_setor" name="nome" value="" placeholder="Digite o nome do Setor">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                            <button class="btn btn-danger" data-dismiss="modal" aria-label="Close">Cancelar</button>
                            <button type="submit" class="btn btn-success" id="submit-setor">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="{{asset('js/ordemFornecimento/index.js')}}"></script>
