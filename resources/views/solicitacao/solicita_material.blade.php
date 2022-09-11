@extends('templates.principal')

@section('title') Solicitar Material @endsection

@section('content')
    <div style="border-bottom: #949494 2px solid; padding-bottom: 5px; margin-bottom: 10px">
        <h2>SOLICITAR MATERIAL</h2>
    </div>

    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <strong>{{session('success')}}</strong>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div id="error" class="alert alert-danger" role="alert" style="margin-top: 10px; display: none">
        Informe o material e a quantidade!
    </div>

    <div id="remocaoSuccess" class="alert alert-success" role="alert" style="margin-top: 10px; display: none">
        Material removido!
    </div>

    <div id="editSuccess" class="alert alert-success" role="alert" style="margin-top: 10px; display: none">
        Material Editado!
    </div>

    <div style="background-color: #D7D7E6">
        <div class="form-row" style="margin-left: 10px">
            <div class="form-group col-md-4">
                <label for="selectUnidadeBasica" style="color: #151631; font-family: 'Segoe UI'; font-weight: 700">Unidade Básica:</label>
                <select class="form-control" name="selectUnidadeBasica" id="selectUnidadeBasica" style="width: 100%">
                    <option></option>
                    @if(Auth::user()->cargo_id == 1)
                        @foreach($unidades as $unidade)
                            <option data-value="{{$unidade->id}}">{{ $unidade->nome }} </option>
                        @endforeach
                    @else
                        <option data-value="{{$unidades->id}}" selected>{{ $unidades->nome }} </option>
                    @endif
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="selectMaterial" style="color: #151631; font-family: 'Segoe UI'; font-weight: 700">Material</label>
                <select id="selectMaterial" class="selectMaterial" class="form-control" style="width: 95%;">
                    <option></option>
                    <option data-value="" disabled>Material[Codigo]</option>
                </select>
            </div>

            <div id="estoquesId">

            </div>
            @foreach($materiais as $material)
                <input type="hidden" id="unidade_{{$material->id}}" value="{{$material->unidade}}">
                @if(Auth::user()->cargo_id == 1)
                    @foreach($unidades as $unidade)
                        <input type="hidden" id="estoque_{{$material->id.$unidade->id}}"
                               value="{{$estoque = \App\Estoque::where('material_id', $material->id)->where('setor_id', $unidade->setor->id)->first()->quantidade}}">
                    @endforeach
                @else
                    <input type="hidden" id="estoque_{{$material->id.$unidades->id}}"
                           value="{{$estoque = \App\Estoque::where('material_id', $material->id)->where('setor_id', $unidades->setor->id)->first()->quantidade}}">
                @endif
            @endforeach
            <div class="form-group col-md-2">
                <label for="quantMaterial" style="color: #151631; font-family: 'Segoe UI'; font-weight: 700">Quantidade</label>
                <input type="text" min="1" class="form-control" id="quantMaterial" name="quantidade" value="{{ old('quantidade') }}">
            </div>

            <div class="form-group col-md-2">
                <button id="addTable" style="margin-top: 30px;" class="btn btn-primary" onclick="addTable()">Adicionar</button>
            </div>
        </div>
    </div>

    <form method="POST" id="formSolicitacao" name="formSolicitacao" action="{{ route('add.material') }}">
        @csrf
        <table id="tableMaterial" class="table table-hover table-responsive-md" style="margin-top: 10px">
            <thead style="background-color: #151631; color: white; border-radius: 15px">
            <tr>
                <th scope="col">Material</th>
                <th scope="col" style="text-align: center">Unidade Básica</th>
                <th scope="col" style="text-align: center">Quantidade</th>
                <th scope="col" style="text-align: center">Estoque</th>
                <th scope="col" style="text-align: center">Unidade</th>
                <th scope="col" style="text-align: center">Ações</th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>

        <input type="hidden" id="dataTableMaterial" name="dataTableMaterial" value="">
        <input type="hidden" id="dataTableQuantidade" name="dataTableQuantidade" value="">
        <input type="hidden" id="dataTableUnidade" name="dataTableUnidade" value="">

        <Button class="btn btn-secondary" type="button" onclick="location.href = '../' "> Cancelar</Button>
        <button id="solicita" class="btn btn-success" disabled onclick="return setValuesRowInput()">Solicitar</button>
    </form>

    <input id="flag" value="xx" hidden>
    <div class="modal fade" id="detalhesSolicitacao" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel" style="color:#151631">Editar Solicitação</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="modalBody">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="selectMaterialEdit" style="color: #151631; font-family: 'Segoe UI'; font-weight: 700;">Material</label>
                                <select id="selectMaterialEdit" style="width: 110%;" class="selectMaterial" class="form-control" name="selectMaterialEdit">
                                    <option></option>
                                </select>
                            </div>

                            <input type="hidden" id="unidade_selected" value="">
                            <div class="form-group col-md-2" style="margin-left: 4%">
                                <label for="InputQuantEdit" style="color: #151631; font-family: 'Segoe UI'; font-weight: 700">Quantidade</label>
                                <input type="number" min="1" onkeypress="return onlyNums(event,this);" class="form-control" id="InputQuantEdit" name="InputQuantEdit" value="{{ old('quantidade') }}">
                            </div>
                            <div class="form-group">
                                <button id="updateMaterial" style="margin-top: 30px; margin-left: 10px" class="btn btn-primary" onclick="confirmarAlteracao()">Atualizar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var cont = 0;
        $('#selectUnidadeBasica').select2({
            placeholder: "Selecione a Unidade Básica.",
            language: {noResults: () => "Nenhum resultado encontrado.",},
        });
    </script>
@endsection

@section('post-script')
    @if(Auth::user()->cargo_id == 1)
        <script type="text/javascript">

            $('#selectUnidadeBasica').change(function () {
                var unidade_id = $("#selectUnidadeBasica option:selected").data('value');

                $.get('/get_materiais/' + unidade_id, function (estoques) {
                    $.each(estoques, function (key, value) {
                        $('#selectMaterial').append(`<option data-value="${value.material_id}" id="Material${value.material_id}">${value.nome}[${value.codigo} - ${value.quantidade}]</option>`);
                        $('#selectMaterialEdit').append(`<option value="${value.material_id}" id="MaterialEdit${value.material_id}">${value.nome}[${value.codigo} - ${value.quantidade}]</option>`);
                        $('#estoquesId').append(`<input type="hidden" id="estoque_${value.material_id}${unidade_id}" value="${value.quantidade}">`);
                    });
                });

            });
        </script>
    @else
        <script type="text/javascript">

            $(function () {
                var unidade_id = $("#selectUnidadeBasica option:selected").data('value');

                $.get('/get_materiais/' + unidade_id, function (estoques) {
                    $.each(estoques, function (key, value) {
                        $('#selectMaterial').append(`<option data-value="${value.material_id}" id="Material${value.material_id}">${value.nome}[${value.codigo}]</option>`);
                        $('#selectMaterialEdit').append(`<option value="${value.material_id}" id="MaterialEdit${value.material_id}">${value.nome}[${value.codigo}}]</option>`);
                        $('#estoquesId').append(`<input type="hidden" id="estoque_${value.material_id}${unidade_id}" value="${value.quantidade}">`);
                    });
                });
            });

        </script>
    @endif
@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
<script type="text/javascript" src="{{asset('js/solicitacoes/solicita_material.js')}}"></script>
