
@extends('../templates.principal')

@section('title')
    Depositos
@endsection

@section('content')

    <div style="border-bottom: #949494 2px solid; padding-bottom: 5px; margin-bottom: 10px">
        <h2>DEPÓSITOS CADASTRADOS</h2>
    </div>

    @if(session()->has('fail'))
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>{{session('fail')}}</strong>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @elseif(session()->has('sucess'))
        <div class="alert alert-success alert-dismissible fade show">
            <strong>{{session('sucess')}}</strong>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <table id="tableDepositos" class="table table-hover table-responsive-md">
        <thead class="terciaria-bg" style="color: white; border-radius: 15px">
             <tr>
                <th class="text-left" scope="col" style="padding-left: 10px">Depósito</th>
                <th scope="col" style="text-align: center">Código</th>
                 <th scope="col" style="text-align: center">Ações</th>
            </tr>
        </thead>
        <tbody>

            @forelse($depositos as $deposito)
                <tr>
                    <td class="text-left" style="text-align: center"> {{ $deposito->nome }} </td>
                    <td style="text-align: center"> {{ $deposito->codigo }} </td>
                    <td style="text-align: center">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                ⋮
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a type="button" class="dropdown-item" onclick="location.href = '{{ route('deposito.edit', $deposito->id) }}'">Editar</a>
                                <a type="button" class="dropdown-item" onclick="if(confirm('Tem certeza que deseja Remover o Deposito?')) location.href='{{route('deposito.destroy', $deposito->id)}}'">Remover</a>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <td colspan="2">Sem depósitos cadastrados ainda</td>
            @endempty
        </tbody>
    </table>
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="{{asset('js/deposito/index.js')}}"></script>
