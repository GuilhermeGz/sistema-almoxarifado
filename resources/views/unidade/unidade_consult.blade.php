@extends('templates.principal')

@section('title')
    Notas Fiscais
@endsection

@section('content')

    <div style="border-bottom: #949494 2px solid; padding-bottom: 5px; margin-bottom: 10px">
        <h2>CONSULTAR UNIDADES BÁSICAS</h2>
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
            <th class="align-middle" scope="col" style="padding-left: 10px">Nome</th>
            <th class="align-middle" scope="col" style="text-align: center; ">CEP</th>
            <th class="align-middle" scope="col" style="text-align: center;">Endereco</th>
            <th class="align-middle" scope="col" style="text-align: center; ">Bairro</th>
            <th class="align-middle" scope="col" style="text-align: center;">Nome do Coordenador</th>
            <th class="align-middle" scope="col" style="text-align: center;">Numero do Coordenador</th>
            <th class="align-middle" scope="col" style="text-align: center; ">Nome da Enfermeira</th>
            <th class="align-middle" scope="col" style="text-align: center; ">Numero da Enfermeira</th>
        </tr>
        </thead>
        <tbody>

        @forelse($unidades as $unidade)
            <tr>
                <td class="text-left" style="text-align: center"> {{ $unidade->nome }} </td>
                <td style="text-align: center"> {{ $unidade->cep }} </td>
                <td style="text-align: center"> {{ $unidade->endereco }}</td>
                <td style="text-align: center"> {{ $unidade->bairro }}</td>
                <td style="text-align: center"> {{ $unidade->nome_coordenador }}</td>
                <td style="text-align: center"> {{ $unidade->numero_coordenador }}</td>
                <td style="text-align: center"> {{ $unidade->nome_enfermeira }}</td>
                <td style="text-align: center"> {{ $unidade->numero_enfermeira }}</td>
            </tr>
        @empty
            <td colspan="9">Sem unidades basicas cadastradas ainda</td>
        @endempty
        </tbody>
    </table>
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="{{asset('js/unidade/index.js')}}"></script>
