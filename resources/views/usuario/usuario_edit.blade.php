@extends('templates.principal')

@section('title')
    Editar Usuário
@endsection

@section('content')

    <div style="border-bottom: #949494 2px solid; padding: 5px; margin-bottom: 10px">
        <h2>EDITAR USUÁRIO</h2>
    </div>

    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <strong>{{session('success')}}</strong>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <form action="{{ route('usuario.update', $usuario->id) }}" enctype="multipart/form-data" method="POST">
        @csrf
        @method('PUT')

        <p style="font-weight: bold; font-size: 15px">Dados Pessoais</p>

        <div class="form-group">

            <div class="form-group">
                <label for="nome"> Nome Completo </label>
                <input class="form-control  @error('nome') is-invalid @enderror" type="text" name="nome" id="nome" maxlength="100" value="{{ old('nome', $usuario->nome) }}"
                        autocomplete="nome" autofocus placeHolder="Nome Completo">
                @error('nome')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="cpf"> CPF </label>
                    <input class="form-control @error('cpf') is-invalid @enderror" value="{{ old('cpf', $usuario->cpf) }}" type="text" name="cpf" id="cpf" autocomplete="cpf"
                            autofocus placeHolder="000.000.000-00">
                    @error('cpf')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="rg"> RG </label>
                    <input class="form-control @error('rg') is-invalid @enderror" value="{{ old('rg', $usuario->rg) }}" type="text" name="rg" id="rg" autocomplete="rg"
                            maxlength="11" autofocus placeHolder="00000000000">
                    @error('rg')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="data_nascimento"> Data de Nascimento </label>
                    <input class="form-control @error('data_nascimento') is-invalid @enderror" autofocus value="{{ old('data_nascimento', $usuario->data_nascimento) }}"
                            type="date" name="data_nascimento" id="data_nascimento" min="1910-01-01">
                    @error('data_nascimento')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <p style="font-weight: bold; font-size: 15px">Informações para contato</p>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="email"> E-mail </label>
                    <input class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $usuario->email) }}" autocomplete="email" autofocus type="email"
                                name="email" id="email" placeHolder="exemplodeemail@upe.br">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="numTel"> Número de Celular </label>
                    <input class="form-control @error('numTel') is-invalid @enderror" type="text" name="numTel"
                            id="numTel" placeHolder="(00)00000-0000" value="{{ $usuario->numTel }}">

                    @error('numTel')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <p style="font-weight: bold; font-size: 15px">Informações institucionais</p>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="matricula"> Matrícula </label>
                    <input class="form-control @error('matricula') is-invalid @enderror" value="{{ old('matricula', $usuario->matricula) }}" type="text" name="matricula"
                            maxlength="11" id="matricula" autocomplete="matricula" autofocus placeHolder="00000000000">
                    @error('matricula')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


                @if(Auth::user()->cargo_id == 1)
                <div class="form-group col-md-6">
                    <label for="cargo"> Perfil </label>
                    <select class="custom-select @error('cargo') is-invalid @enderror" autofocus name="cargo" id="cargo">
                        <option value="{{ $usuario->cargo_id }}"
                                selected="selected">{{ $usuario->getCargo($usuario->cargo_id)->nome }}</option>
                        @foreach( $cargos as $cargo )
                            @if( $cargo->id != $usuario->cargo_id )
                                <option value="{{ $cargo->id }}"> {{ $cargo->nome }} </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                @else
                    <input type="hidden" id="cargo" name="cargo" value="{{$usuario->cargo_id}}">
                @endif
            </div>

            <hr>

            <div class="form-row">
                <div class="col-sm-auto">
                    <Button class="btn btn-secondary" type="button" onClick="if(confirm('Tem certeza que deseja Cancelar a alteração do Usuário?')) location.href='../'"> Cancelar </Button>
                </div>
                <div class="col-sm-auto">
                    <Button class="btn btn-success" type="submit" onclick="return confirm('Tem certeza que deseja Atualizar o Usuário?')" disabled id="atualizar"> Atualizar </Button>
                </div>
            </div>
        </div>
    </form>
@endsection
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="{{asset('js/usuario/edit.js')}}"></script>
<script type="text/javascript" src="{{asset('js/usuario/CheckFields.js')}}"></script>
