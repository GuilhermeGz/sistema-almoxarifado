@extends('templates.principal')

@section('title') Cadastrar Unidade Basica @endsection

@section('content')
    <div style="border-bottom: #949494 2px solid; padding: 5px; margin-bottom: 10px">
        <h2>CADASTRAR UNIDADE BÁSICA</h2>
    </div>

    <form method="POST" action="{{ route('alterar.unidade') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="unidade_id" value="{{$unidade->id}}">

        <div class="form-group">
            <h2 class="h4"> Informações da Unidade Básica </h2>
        </div>

        <div class="form-group row">
            <div class="col-md-12">
                <label for="nome">Nome<span style="color: red">*</span></label>
                <input class="form-control" type="text" id="nome" name="nome" placeholder="Digite o nome da unidade básica" value="{{$unidade->nome}}" required>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <label for="nome_coordenador">Nome do Coordenador<span style="color: red">*</span></label>
                <input class="form-control" type="text" id="nome_coordenador" name="nome_coordenador" placeholder="Digite o nome do coordenador" value="{{$unidade->nome_coordenador}}" required>
            </div>
            <div class="col-md-6">
                <label for="numero_coordenador">Numero do Coordenador<span style="color: red">*</span></label>
                <input class="form-control" type="text" id="fone" name="numero_coordenador" placeholder="Digite o número do coordenador" value="{{$unidade->numero_coordenador}}" required>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6">
                <label for="nome_enfermeira">Nome da Enfermeira<span style="color: red">*</span></label>
                <input class="form-control" type="text" id="nome_enfermeira" name="nome_enfermeira" placeholder="Digite o nome da enfermeira" value="{{$unidade->nome_enfermeira}}" required>
            </div>
            <div class="col-md-6">
                <label for="numero_enfermeira">Numero da Enfermeira<span style="color: red">*</span></label>
                <input class="form-control" type="text" id="fone2" name="numero_enfermeira" placeholder="Digite o número da enfermeira" value="{{$unidade->numero_enfermeira}}" required>
            </div>
        </div>

        <div class="form-group">
            <h2 class="h4"> Endereço da Unidade Básica </h2>
        </div>

        <div class="form-group row">
            <div class="col-md-4">
                <label for="cep">CEP<span style="color: red">*</span></label>
                <input class="form-control" type="text" id="cep" name="cep"  onblur="pesquisacep(this.value)" placeholder="Digite o cep da unidade básica" value="{{$unidade->cep}}" required>
            </div>

            <div class="col-md-4">
                <label for="endereco">Endereco<span style="color: red">*</span></label>
                <input class="form-control" type="text" id="endereco" name="endereco" placeholder="Digite o endereco da unidade básica" value="{{$unidade->endereco}}" required>
            </div>

            <div class="col-md-4">
                <label for="bairro">Bairro<span style="color: red">*</span></label>
                <input class="form-control" type="text" id="bairro" name="bairro" placeholder="Digite o bairro da unidade básica" value="{{$unidade->bairro}}" required>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-4">
                <Button class="btn btn-secondary" type="button"
                        onclick="if(confirm('Tem certeza que deseja Cancelar a alteração do Material?')) location.href = '../' ">
                    Cancelar
                </Button>
                <button type="submit" class="btn btn-success">Alterar</button>
            </div>
        </div>
    </form>
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="{{asset('js/material/CheckFields.js')}}"></script>
<script type="text/javascript" src="{{asset('js/unidade/busca.js')}}"></script>

