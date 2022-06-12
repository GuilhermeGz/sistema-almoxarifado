
@extends('../templates.principal')

@section('title')
    Perfis
@endsection

@section('content')

    <div style="border-bottom: #949494 2px solid; padding-bottom: 5px; margin-bottom: 10px">
        <h2>PERFIS CADASTRADOS</h2>
    </div>

    <table id="tableCargos" class="table table-hover table-responsive-md">
        <thead class="terciaria-bg" style="color: white; border-radius: 15px">
            <th> Nome </th>
        </thead>

        <tbody>
        @foreach($cargos as $cargo)
            <tr onclick="location.href = '{{ route('cargo.edit', ['cargo' => $cargo->id]) }}'" style="cursor: pointer;">
                <td> {{ $cargo->nome }} </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tableCargos').DataTable({
            searching: false,
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "info": "Exibindo página _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhum registro disponível",
                "zeroRecords": "Nenhum registro disponível",
                "paginate": {
                    "previous": "Anterior",
                    "next": "Próximo"
                }
            },
            "order": [],
            "columnDefs": [ {
                "targets"  : [],
                "orderable": false
            }]
        });
    });
</script>
