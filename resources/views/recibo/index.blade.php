@extends('templates.principal')

@section('title')
    Notas Fiscais
@endsection

@section('content')

    <div style="border-bottom: #949494 2px solid; padding-bottom: 5px; margin-bottom: 10px">
        <h2>Lista de Recibos</h2>
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
            <th class="align-middle" scope="col" style="padding-left: 10px; width: 5%">Identificador</th>
            <th class="align-middle" scope="col" style="text-align: center; ">Data</th>
            <th class="align-middle" scope="col" style="text-align: center; width: 5%">Ações</th>
        </thead>
        <tbody>

        @foreach($recibos as $recibo)
            <tr>
                <td class="text-left" style="text-align: center"> {{ $recibo->id }} </td>
                <td style="text-align: center"> {{ $recibo->created_at->format('d/m/Y') }} </td>
                <td style="text-align: center"><a href="{{route('unidade.recibo.baixar', ['id' => $recibo->id])}}" class="btn-success btn" type="button">Baixar</a></td>
            </tr>
        @endforeach

        </tbody>
    </table>
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
                "targets": [2],
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
