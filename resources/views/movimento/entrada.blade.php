@extends('templates.principal')

@section('title') Entrada de Material @endsection

@section('content')
    <div style="border-bottom: #949494 2px solid; padding-bottom: 5px; margin-bottom: 10px">
        <h2>ENTRADA DE MATERIAL</h2>
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

    <form method="POST" action="{{ route('movimento.entradaStore') }}">
        @csrf
        <div class="form-row" style="border-bottom: #cfc5c5 1px solid; padding: 0 0 20px 0; margin-bottom: 20px">
            <div class="col-md-4">
                <label for="selectNotas">Nota Fiscal</label>
                <select class="form-control selectNota" id="selectNotas" name="nota_fiscal_id" style="width: 95%;">
                    <option></option>
                    @foreach($notas as $nota)
                        <option value="{{$nota->id}}">{{$nota->numero}} - {{$nota->emitente->razao_social}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="selectSetor">Setor</label>
                <select class="form-control selectSetor" id="selectSetor" name="setor_id" style="width: 95%;">
                    <option></option>
                    @foreach($setores as $setor)
                        <option value="{{$setor->id}}">{{$setor->nome}}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <div>
            <div class="form-group col-md-12" class="form-row" style="border-bottom: #cfc5c5 1px solid; padding: 0 0 20px 0; margin-bottom: 20px">
                <label for="inputDescricao">Descrição</label>
                <textarea class="form-control @error('descricao') is-invalid @enderror" autofocus name="descricao"
                          id="inputDescricao" cols="30" rows="3" min="5" max="255" required>{{old('descricao')}}</textarea>
                @error('descricao')
                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>

                @enderror
            </div>
        </div>
        <input type="hidden" name="operacao" value="0">

        <Button class="btn btn-secondary" type="button" onclick="location.href = '../' "> Cancelar</Button>
        <button class="btn btn-success" type="submit">Registrar Estoque</button>
    </form>

@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
<script type="text/javascript" src="{{asset('js/movimento/CheckFields.js')}}"></script>
<script type="text/javascript" src="{{asset('js/movimento/entrada_material.js')}}"></script>

<script>
    $(document).ready(function () {
        var materialUnidade;

        $("#selectMaterial").change(function () {
            materialUnidade = $("#unidade_" + this.value).val();
            $("#materialUnidade").val(materialUnidade)
        });
    });
</script>
