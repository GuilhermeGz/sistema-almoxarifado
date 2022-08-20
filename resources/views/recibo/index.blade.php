@extends('templates.principal')

@section('title')
    Notas Fiscais
@endsection

@section('content')

    <div style="border-bottom: #949494 2px solid; padding-bottom: 5px; margin-bottom: 10px">
        <h2>Unidade {{$unidade->nome}} - Lista de Recibos</h2>
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

    <table id="tableReciboIndex" class="table table-hover table-responsive-md">
        <thead style="background-color: #151631; color: white; border-radius: 15px">
        <tr>
            <th class="align-middle" scope="col" style="padding-left: 10px; width: 5%">Identificador</th>
            <th class="align-middle" scope="col" style="text-align: center">Unidade</th>
            <th class="align-middle" scope="col" style="text-align: center; ">Data</th>
            <th class="align-middle" scope="col" style="text-align: center; width: 5%">Ações</th>
        </thead>
        <tbody>

        @foreach($recibos as $recibo)
            <tr>
                <td class="text-left"> {{ $recibo->id }} </td>
                <td style="text-align: center"> {{ $recibo->unidade->nome }} </td>
                <td style="text-align: center"> {{ $recibo->created_at->format('d/m/Y - H:i:s') }} </td>
                <td style="text-align: center"><a class="btn btn-group border-dark" href="{{route('unidade.recibo.baixar', ['id' => $recibo->id])}}" title="Baixar Recibo"><i class="fa-solid fa-download"></i></a></td>
            </tr>
        @endforeach

        </tbody>
    </table>
    <a type="button" href="{{route('index.unidade', ['id' => $unidade->setor->id])}}" class="btn btn-danger m-1" style="width: 150px">Voltar</a>
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="{{asset('js/recibo/index.js')}}"></script>
