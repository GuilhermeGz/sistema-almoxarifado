@extends('templates.principal')

@section('title') Cadastrar Unidade Basica @endsection

@section('content')
    <div style="border-bottom: #949494 2px solid; padding: 5px; margin-bottom: 10px">
        <h2>CADASTRAR UNIDADE BASICA</h2>
    </div>

    <form method="POST" action="{{ route('criar.unidade') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group row">
            <div class="col-md-12">
                <label for="nome">Nome<span style="color: red">*</span></label>
                <input class="form-control" type="text" id="nome" name="nome" placeholder="Digite o nome da unidade básica" required>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-4">
                <label for="cep">CEP<span style="color: red">*</span></label>
                <input class="form-control" type="text" id="cep" name="cep" placeholder="Digite o cep da unidade básica" required>
            </div>

            <div class="col-md-4">
                <label for="endereco">Endereco<span style="color: red">*</span></label>
                <input class="form-control" type="text" id="endereco" name="endereco" placeholder="Digite o endereco da unidade básica" required>
            </div>

            <div class="col-md-4">
                <label for="bairro">Bairro<span style="color: red">*</span></label>
                <input class="form-control" type="text" id="bairro" name="bairro" placeholder="Digite o bairro da unidade básica" required>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-4">
                <Button class="btn btn-secondary" type="button"
                        onclick="if(confirm('Tem certeza que deseja Cancelar o cadastro do Material?')) location.href = '../' ">
                    Cancelar
                </Button>
                <button type="submit" class="btn btn-success">Cadastrar</button>
            </div>
        </div>
    </form>
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="{{asset('js/material/CheckFields.js')}}"></script>
