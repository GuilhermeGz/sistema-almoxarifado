@extends('templates.principal')

@section('title')
    Setor
@endsection

@section('content')

    <div class="row" style="border-bottom: #949494 2px solid; padding-bottom: 5px; margin-bottom: 10px">
        <div class="col-md-10">
            <h2>Setores Cadastrados</h2>
        </div>
        <div class="col-md-2">
            <h2 class="text-right" style="color: #23CF5C!important;" title="Cadastrar Setor">
                <a type="button" data-toggle="modal" data-target="#setorModal"><i class="fa-solid fa-circle-plus"></i></a>
            </h2>
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

    <table id="tableNotas" class="table table-hover table-responsive-md">
        <thead style="background-color: #151631; color: white; border-radius: 15px">
        <tr>
            <th class="align-middle" scope="col" style="padding-left: 10px;width: 5%">Id</th>
            <th class="align-middle" scope="col" style="padding-left: 10px">Nome</th>
            <th class="align-middle" scope="col" style="text-align: center; width: 10%">Ações</th>
        </tr>
        </thead>
        <tbody>

        @forelse($setores as $setor)
            <tr>
                <td class="text-left" style="text-align: center"> {{ $setor->id }} </td>
                <td class="text-left" style="text-align: center"> {{ $setor->nome }} </td>
                <td class="text-left" style="text-align: center">
                    <div class="row">
                        <div class="col-md-4">
                            <a type="button" href="{{route('index.unidade', ['id' => $setor->id])}}" style="color: #212529" title="Unidades"><i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 23px"></i></a>
                        </div>
                        <div class="col-md-4">
                            <a type="button" data-toggle="modal" data-target="#setorEditModal{{$setor->id}}" title="Editar"><i class="fa-solid fa-pen-to-square" style="font-size: 23px"></i></a>
                        </div>
                        <div class="col-md-4">
                            <a type="button" onclick="if(confirm('Tem certeza que deseja Remover {{$setor->nome}}?')) location.href='{{route('remover.setor', ['id' => $setor->id])}}'" title="Remover"><i class="fa-solid fa-trash-can" style="font-size: 23px"></i></a>
                        </div>
                    </div>
                </td>
            </tr>

            <div class="modal fade" id="setorEditModal{{$setor->id}}" tabindex="-1" role="dialog" aria-labelledby="setorEditModal{{$setor->id}}" aria-hidden="true">
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
                            <input type="hidden" name="setor_id" value="{{$setor->id}}">
                            <div class="modal-body">
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="nome_setor">Nome<span style="color: red">*</span></label>
                                        <input class="form-control" id="nome_setor" name="nome" value="{{$setor->nome}}" placeholder="Digite o nome do Setor">
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
            <td colspan="10">Sem setores cadastrados ainda</td>
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

<script>
    $(function () {
        $('#tableNotas').DataTable({
            searching: true,
            "language": {
                "search": "Pesquisar:",
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "info": "Exibindo página _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhum registro disponível",
                "zeroRecords": "Nenhum registro disponível",
                "paginate": {
                    "previous": "Anterior",
                    "next": "Próximo"
                }
            },
            "columnDefs": [{
                "targets": [8],
                "orderable": false
            }]
        });

        $('#tableNotas').on('page.dt', function () {
            $('html, body').animate({
                scrollTop: $(".dataTables_wrapper").offset().top
            }, 'fast');
        });

        $('#tableNotas').DataTable().columns().iterator('column', function (ctx, idx) {
            $($('#tableNotas').DataTable().column(idx).header()).append('<span class="sort-icon"/>');
        });

    });
</script>
