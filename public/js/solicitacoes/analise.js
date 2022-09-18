function showItens(id) {
    $("#overlay").show();

    $("#detalhesSolicitacao").modal('show');

    $('#numSolicitacao').text(id);


    $.ajax({
        url: '/itens_solicitacao_admin/' + id,
        type: 'GET',
        dataType: 'json',
        success: function (info) {
            var ret = '';
            var data = info[0];
            for (var item in data) {
                    ret += "<tr>";
                    ret += "<td>" + data[item]['nome'] + "</td>";
                    ret += "<td>" + data[item]['descricao'] + "</td>";
                    ret += "<td style=\"text-align: center\">" + data[item]['unidade'] + "</td>";
                    ret += "<td style=\"text-align: center\">" + data[item]['quantidade_solicitada'] + "</td>";
                    ret += "<td style=\"text-align: center\">" + data[item]['quantidade'] + "</td>";
                    ret += "<td style=\"text-align: center\">" + '<input class="quantMateriais" min=\"1\" style=\"width: 85%\" type=\"text\" id=\"inputQuantAprovada\"';
                    ret += 'name=\"quantAprovada[]\" value=\"' + (data[item]['quantidade_aprovada'] == null ? '' : data[item]['quantidade_aprovada']) + '\">' + "</td>";
                    ret += "<td style=\"text-align: center\">" + "<a onclick=\"showTrocaMaterial(" + data[item]['material_id'] + "," + data[item]['solicitacao_id'] + ", '" + data[item]['nome'] + "')\"  type=\"button\" class=\"btn btn-primary\">Trocar</a>" + "</td>";
                    ret += "</tr>";

                }

            $('#textObservacaoRequerente').val(info[1]['observacao_requerente']);
            $('#solicitacaoID').val(id);
            $("#tableItens tbody").append(ret);
            $("#overlay").hide();
            $("#modalBody").show();
            $('#negaSolicitacao').show();
            $('#aprovaSolicitacao').show();
        }
    });
}

function showTrocaMaterial(material_id, solicitacao_id, material_nome) {

    $("#trocaConteudo").html("");
    $.ajax({
        url: '/itens_troca_admin/' + material_id + '/' + solicitacao_id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            var ret = "";
            if (data.length > 0) {
                ret += "<div class=\"col-md-4\"/>";
                ret += "<label for=\"itemAtual\"><strong>Material escolhido:</strong></label>";
                ret += "<input type=\"hidden\" class=\"form-control\" id=\"itemAtual\" name=\"itemAtual\" value=\"" + material_id + "\">";
                ret += "<input type=\"hidden\" class=\"form-control\" id=\"solicitacao_id\" name=\"solicitacao_id\" value=\"" + solicitacao_id + "\">";
                ret += "<input class=\"form-control\" value=\"" + material_nome + "\" readonly>";
                ret += "</div>";

                ret += "<div class=\"col-md-4\"/>";
                ret += "<label for=\"selectTrocaItem\"><strong>Materiais em estoque:</strong></label>";
                ret += "<select class=\"form-select form-control\" id=\"itemSelecionado\" name=\"itemSelecionado\" '>";
                for (var item in data) {
                    ret += "<option value=\"" + data[item]['material_id'] + "\">" + data[item]['nome'] + " - " + data[item]['quantidade'] + "</option>";
                }
                ret += "</select>";
                ret += "</div>";

                ret += "<div class=\"col-md-4\"/>";
                ret += "<label for=\"quant_material\"><strong>Quantidade:</strong></label>";
                ret += "<input type=\'number\' class=\"form-control\" id=\"quant_material\" name=\"quant_material\" value=\"\">";
                ret += "</div>";
            }else{
                ret += "<h1>Não existe material para a troca</h1>";
            }

            $("#trocaConteudo").append(ret);
            $("#detalhesSolicitacao").modal('hide');
            setTimeout(() => {
                $("#infoTroca ").modal();
            }, 500);

        }
    });
}

$(function () {

    $(document).on("focus", ".quantMateriais", function(){
        $(this).mask("#", {
            maxlength: false,
            translation: {
                '#': { pattern: /[0-9]/, recursive: true }
            }
        })
     });

    var buttonSubmitID = "";

    $('#textObservacaoAdmin').on('input propertychange', function () {
        if ($(this).val().length < 5) {
            $('#negaSolicitacao').prop('disabled', true);
            $('#aprovaSolicitacao').prop('disabled', true);
        } else {
            $('#negaSolicitacao').prop('disabled', false);
            $('#aprovaSolicitacao').prop('disabled', false);
        }
    });

    $("#formSolicitacao button[type = 'submit']").on("click", function () {
        buttonSubmitID = $(this).attr("id");
    });

    $("#formSolicitacao").on("submit", function () {
        let escolha = "";
        if (buttonSubmitID == "aprovaSolicitacao") {
            escolha = confirm("Tem certeza que deseja aprovar a solicitação?");
            if (escolha) {
                vari = $('[name="quantAprovada[]"]');
                count = 0;
                for (var i = 0; i < vari.length; i++) {
                    if (vari[i]['value'] == "") {
                        count++;
                    }
                }
                if (count == vari.length) {
                    alert("Informe algum valor para a quantidade aprovada");
                    return false;
                }
            } else {
                return false;
            }
        } else if (buttonSubmitID == "negaSolicitacao") {
            escolha = confirm("Tem certeza que deseja negar a solicitação?");
            if (!escolha)
                return false;
        }
    });

    var table = $('#tableSolicitacoes').DataTable({
        searching: false,
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "info": "Exibindo página _PAGE_ de _PAGES_",
            "infoEmpty": "Nenhum registro disponível",
            "zeroRecords": "Nenhum registro disponível",
            "paginate": {
                "previous": "Anterior",
                "next": "Próximo"
            }
        },
        "order": [],
        "columnDefs": [{
            "targets": [2],
            "orderable": false
        }]
    });

    $('#tableSolicitacoes tbody').on('click', 'td.expandeOption', function (e) {
        e.preventDefault();
        e.stopPropagation();

        var tr = $(this).closest('tr');
        var row = table.row(tr);
        var id = tr.data('id');

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            $.ajax({
                url: '/itens_solicitacao_admin/' + id,
                type: 'GET',
                dataType: 'json',
                success: function (info) {
                        var data = info[0];
                        var ret = '<table id=\"tableExpanded\" class=\"table table-hover table-responsive-md\"">' +
                            '<thead>' +
                            '<tr>' +
                            '<th scope=\"col\" class=\"align-middle\">Material</th>' +
                            '<th scope=\"col\" class=\"align-middle\">Descrição</th>' +
                            '<th scope=\"col\" style=\"text-align: center; width: 10%\">Qtd. Solicitada</th>' +
                            '</tr>' +
                            '</thead>' +
                            '<tbody>';
                        for (var item in data) {
                            ret += "<tr data-id=" + id + " onclick=\"showItens( " + id + "  )\" style=\"cursor: pointer;\">";
                            ret += "<td>" + data[item]['nome'] + "</td>";
                            ret += "<td>" + data[item]['descricao'] + "</td>";
                            ret += "<td style=\"text-align: center\">" + data[item]['quantidade_solicitada'] + "</td>";
                            ret += "</tr>";
                        }
                    row.child(ret).show();
                    tr.addClass('shown');
                }

            });
        }
    });

    $('#detalhesSolicitacao').on('hidden.bs.modal', function (e) {
        $('#solicitacaoID').val(0);
        $("#modalBody").hide();
        $('#negaSolicitacao').hide();
        $('#aprovaSolicitacao').hide();
        $("#listaItens").empty();
    });

    $('#tableSolicitacoes').on('page.dt', function () {
        $('html, body').animate({
            scrollTop: $(".dataTables_wrapper").offset().top
        }, 'fast');
    });

    $('#tableSolicitacoes').DataTable().columns().iterator('column', function (ctx, idx) {
        $($('#tableSolicitacoes').DataTable().column(idx).header()).append('<span class="sort-icon"/>');
    });
});
