@extends('templates.principal')

@section('title') Cadastrar Unidade Basica @endsection

@section('content')
    <div style="border-bottom: #949494 2px solid; padding: 5px; margin-bottom: 10px">
        <h2>CADASTRAR ORDEM DE FORNECIMENTO</h2>
    </div>

    <form method="POST" action="{{ route('store.ordemFornecimento') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <h2 class="h4"> Informações</h2>
        </div>

        <div class="form-group row">
            <div class="col-md-4">
                <label for="nome">Código<span style="color: red">*</span></label>
                <input class="form-control" type="text" id="codigo" name="codigo" placeholder="Digite o código da ordem de fornecimento" required>
            </div>
            <div class="col-md-4">
                <label for="nome">Número do Contrato<span style="color: red">*</span></label>
                <input class="form-control" type="text" id="num_contrato" name="num_contrato" placeholder="Digite o número do contrado" required>
            </div>
            <div class="col-md-4">
                <label for="nome">Pregão<span style="color: red">*</span></label>
                <input class="form-control" type="text" id="pregao" name="pregao" placeholder="Digite o pregão" required>
            </div>

        </div>

        <div class="form-group row">
            <div class="col-md-4">
                <a class="btn btn-secondary" type="button" href="{{route('index.ordemFornecimento')}}">Cancelar</a>
                <button type="submit" class="btn btn-success">Cadastrar</button>
            </div>
        </div>
    </form>
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
