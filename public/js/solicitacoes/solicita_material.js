$(function () {
    $('.selectMaterial').select2({
        placeholder: "Digite algo ou selecione uma opção."
    });

    $('#checkReceptor').on('change', function () {
        if ($(this).prop('checked')) {
            $("#inputNomeReceptor").prop('disabled', true);
            $("#inputNomeReceptor").val($("#nomeReceptor").val())
            $("#inputRgReceptor").prop('disabled', true);
            $("#inputRgReceptor").val($("#rgReceptor").val())
            $("#inputTipoReceptor").prop('disabled', true);
            $("#inputTipoReceptor").prop('selectedIndex', 0);
        } else {
            $("#inputNomeReceptor").prop('disabled', false);
            $("#inputNomeReceptor").val('')
            $("#inputRgReceptor").prop('disabled', false);
            $("#inputRgReceptor").val('')
            $("#inputTipoReceptor").prop('disabled', false);
        }
    });
});

var _row = null;

function construirTable(quantidade, unidade, estoque, materialId) {
    return "<td class=\"quantidadeRow\" style=\"text-align: center\">" + quantidade + "</td>" +
        "<td class=\"estoqueRow\" style=\"text-align: center\">" + estoque + "</td>" +
        "<td class=\"unidadeRow\" style=\"text-align: center\">" + unidade + "</td>" +
        "<td style=\"text-align: center\">" +
        "<div class=\"dropdown\">" +
        "<button class=\"btn btn-secondary dropdown\" type=\"button\" id=\"dropdownMenuButton\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">" +
        "⋮" +
        "</button>" +
        "<div class=\"dropdown-menu\" aria-labelledby=\"dropdownMenuButton\">" +
        "<a type=\"button\" class=\"dropdown-item\" onclick=\"removerMaterial(this," + materialId + ")\">Remover</a>" +
        "<a type=\"button\" class=\"dropdown-item\" onclick=\"editarMaterial(this," + materialId + ")\">Editar</a>" +
        "</div>" +
        "</div>" +
        "</td>" +
        "</tr>";
}

function editarMaterial(ctl, materialId) {
    document.getElementById('flag').value = materialId;
    $("#detalhesSolicitacao").modal('show');
    _row = $(ctl).parents("tr");
    var dados = $(ctl).parents("tr").children("td");
    $("#selectMaterialEdit").val($(dados[0]).data('id')).trigger('change');
    $("#InputQuantEdit").val($(dados[1]).text());
}

function confirmarAlteracao() {
    if ($("#selectMaterialEdit option:selected").index() > 0 && $("#InputQuantEdit").val() != '') {
        var escolha = confirm("Tem certeza que deseja fazer as alterações?");
        if (escolha) {
            document.getElementById("Material" + $("#selectMaterialEdit option:selected").index()).disabled = true;
            document.getElementById("MaterialEdit" + $("#selectMaterialEdit option:selected").index()).disabled = true;
            updateRowTable();
            $("#detalhesSolicitacao").modal('hide');
            $("#selectMaterial").val(0).trigger('change');
            $("#InputQuantEdit").val();
        }
    } else {
        alert('Informe o material e a quantidade');
    }
}

function removerMaterial(ctl, materialId) {
    var escolha = confirm("Tem certeza que deseja remover o(s) material(is)?");
    if (escolha) {
        $('#Material' + materialId).prop('disabled', false);
        $('#MaterialEdit' + materialId).prop('disabled', false);
        deleteRow(ctl);
        cont -= 1;
        $('#remocaoSuccess').slideDown();

        if (cont == 0) {
            $('#selectUnidadeBasica').prop('disabled', false);
        } else {
            $('#selectUnidadeBasica').disable(true);
        }

        setTimeout(function () {
            $('#remocaoSuccess').slideUp();
        }, 4000);
    }
}

function updateRowTable() {
    var materialId;
    materialId = $("#selectMaterialEdit option:selected").val();
    var materialId2 = $("#flag").val();
    if (materialId2 != materialId) {
        $('#Material' + materialId2).prop('disabled', false);
        $('#MaterialEdit' + materialId2).prop('disabled', false);
    }
    $("#unidade_selected").val($("#unidade_" + materialId).val())
    $(_row).after(
        "<tr data-id=" + $("#selectMaterialEdit option:selected").val() + ">" +
        "<td data-id=" + $("#selectMaterialEdit option:selected").val() + " class=\"materialRow\">" + $("#selectMaterialEdit option:selected").text() + "</td>" +
        "<td style=\"text-align: center\" data-id=" + $("#selectUnidadeBasica option:selected").data('value') + " class=\"unidadeRow\">" + $("#selectUnidadeBasica option:selected").text() + "</td>"
        + construirTable($("#InputQuantEdit").val(), $("#unidade_selected").val(), $("#estoque_" + materialId).val(), materialId)
    );
    $(_row).remove();
    clearFields();
    $('#editSuccess').slideDown();
    setTimeout(function () {
        $('#editSuccess').slideUp();
    }, 4000);
}

function clearFields() {
    $("#selectMaterial").val("").trigger('change');
    $("#quantMaterial").val("");
}

function deleteRow(ctl) {
    $(ctl).parents("tr").remove();

    if ($("#tableMaterial >tbody >tr").length == 0) {
        $("#solicita").attr("disabled", true);
    }
}

function setValuesRowInput() {
    var materiais = [];
    var quantidades = [];
    var unidades = [];

    var escolha = confirm("Tem certeza que deseja fazer uma solicitação?");

    $("#tableMaterial > tbody > tr").children('.materialRow').each(function () {
        materiais.push($(this).data('id'));
    });

    $("#tableMaterial > tbody > tr").children('.quantidadeRow').each(function () {
        quantidades.push($(this).text());
    });

    $("#tableMaterial > tbody > tr").children('.unidadeRow').each(function () {
        unidades.push($(this).data('id'));
    });

    $('#dataTableMaterial').val([materiais]);
    $('#dataTableQuantidade').val([quantidades]);
    $('#dataTableUnidade').val([unidades]);
}

function addTable() {
    var materialId;
    materialId = $("#selectMaterial option:selected").data('value');
    document.getElementById("Material" + materialId).disabled = true;
    document.getElementById("MaterialEdit" + materialId).disabled = true;

    $("#unidade_selected").val($("#unidade_" + materialId).val())
    if ($("#selectMaterial option:selected").index() > 0 && $("#quantMaterial").val() != '') {
        $("#tableMaterial tbody").append("<tr data-id=" + $("#selectMaterial option:selected").data('value') + ">" +
            "<td data-id=" + $("#selectMaterial option:selected").data('value') + " class=\"materialRow\">" + $("#selectMaterial option:selected").text() + "</td>" +
            "<td style=\"text-align: center\" data-id=" + $("#selectUnidadeBasica option:selected").data('value') + " class=\"unidadeRow\">" + $("#selectUnidadeBasica option:selected").text() + "</td>" +
            construirTable($("#quantMaterial").val(), $("#unidade_selected").val(), $("#estoque_" + materialId).val(), materialId));
        document.getElementById("selectUnidadeBasica").disabled = true;
    } else {
        $('#error').slideDown();
        setTimeout(function () {
            $('#error').slideUp();
        }, 5000);
    }
    clearFields();

    if ($("#tableMaterial >tbody >tr").length > 0) {
        $("#solicita").attr("disabled", false);
    }
    cont += 1;
}

function rgLength() {
    var rg = $("#inputRgReceptor").val().length;
    if (rg > 11) {
        $("#inputRgReceptor").val($("#inputRgReceptor").val().substring(0, $("#inputRgReceptor").val().length - 1));
        return false;
    }
}

function onlyLetters(e, t) {
    try {
        if (window.event) {
            var charCode = window.event.keyCode;
        } else if (e) {
            var charCode = e.which;
        } else {
            return true;
        }
        if (
            (charCode > 64 && charCode < 91) ||
            (charCode > 96 && charCode < 123) ||
            (charCode > 191 && charCode <= 255) || charCode == 32
        ) {
            return true;
        } else {
            return false;
        }
    } catch (err) {
        alert('Digite apenas letras no nome');
    }
}

$(function () {
    $("#quantMaterial").mask("#", {
        maxlength: true,
        translation: {
            '#': {pattern: /[0-9]/, recursive: true}
        }
    });

    $("#inputNomeReceptor").mask("#", {
        maxlength: true,
        translation: {
            '#': {pattern: /^[A-Za-záâãéêíóôõúçÁÂÃÉÊÍÓÔÕÚÇ\s]+$/, recursive: true}
        }
    });


    $("#inputRgReceptor").mask("#", {
        maxlength: true,
        translation: {
            '#': {pattern: /[0-9]/, recursive: true}
        }
    });
})
