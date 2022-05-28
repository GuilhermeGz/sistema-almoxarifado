@extends('templates.principal')

@section('title')
    Editar Perfil
@endsection

@section('content')

    <div style="border-bottom: #949494 2px solid; padding: 5px; margin-bottom: 10px">
        <h2>EDITAR PERFIL</h2>
    </div>

    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <strong>{{session('success')}}</strong>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <form action="{{ route('usuario.update_perfil', $usuario->id) }}" enctype="multipart/form-data" method="POST">
        @csrf
        @method('PUT')

        <p style="font-weight: bold; font-size: 15px">Dados Pessoais</p>

        <div class="form-group">
            <div class="form-group">
                <label for="nome"> Nome Completo </label>
                <input class="form-control @error('nome') is-invalid @enderror" type="text" name="nome" id="nome"
                       maxlength="100" placeHolder="Nome Completo"
                       value="{{ $usuario->nome }}">

                @error('nome')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="cpf"> CPF </label>
                    <input class="form-control @error('cpf') is-invalid @enderror" type="text" name="cpf" id="cpf"
                           min="0" placeHolder="000.000.000-00" value="{{ $usuario->cpf }}">

                    @error('cpf')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="rg"> RG </label>
                    <input class="form-control @error('rg') is-invalid @enderror" type="text" name="rg" id="rg"
                           min="0" maxlength="11" placeHolder="00000000000"
                           value="{{ $usuario->rg }}">

                    @error('rg')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="data_nascimento"> Data de Nascimento </label>
                    <input class="form-control @error('data_nascimento') is-invalid @enderror" type="date"
                           name="data_nascimento" id="data_nascimento" min="1910-01-01"
                           value="{{ $usuario->data_nascimento }}">

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
                    <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" id="email"
                        placeHolder="exemplodeemail@upe.br"
                        value="{{ $usuario->email }}">

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
                <div class="form-group col-md-4">
                    <label for="matricula"> Matrícula </label>
                    <input class="form-control @error('matricula') is-invalid @enderror" type="text" name="matricula"
                            id="matricula" min="0" maxlength="11" placeHolder="00000000000" value="{{ $usuario->matricula }}">

                    @error('matricula')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="setor"> Setor </label>
                    <select id="setor" class="form-control" name="setor">
                        @if($usuario->setor == 'Administrativo')
                            <option selected value="Administrativo">Administrativo</option>
                            <option value="Academico">Acadêmico</option>
                            <option value="Administrativo/Academico">Administrativo/Acadêmico</option>
                        @elseif($usuario->setor == 'Academico')
                            <option value="Administrativo">Administrativo</option>
                            <option selected value="Academico">Acadêmico</option>
                            <option value="Administrativo/Academico">Administrativo/Acadêmico</option>
                        @else
                            <option value="Administrativo">Administrativo</option>
                            <option value="Academico">Acadêmico</option>
                            <option selected value="Administrativo/Academico">Administrativo/Acadêmico</option>
                        @endif
                    </select>
                </div>

                @if(Auth::user()->cargo_id == 1)
                    <div class="form-group col-md-4">
                        <label for="cargo"> Perfil </label>
                        <select class="custom-select" name="cargo" id="cargo">
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
                    <a href="{{ route('home') }}" class="btn btn-secondary"
                       onclick="return confirm('Tem certeza que deseja cancelar a alteração do perfil do Usuário?')">
                        Cancelar </a>
                </div>
                <div class="col-sm-auto">
                    <Button class="btn btn-success" type="submit" disabled
                            onclick="return confirm('Tem certeza que deseja atualizar o perfil do Usuário?')"
                            id="atualizar"> Atualizar
                    </Button>
                </div>
            </div>

        </div>
    </form>
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="{{asset('js/usuario/edit.js')}}"></script>
<script type="text/javascript" src="{{asset('js/usuario/CheckFields.js')}}"></script>
