function showItens(id) {
    $("#overlay").show();

    $("#detalhesSolicitacao").modal('show');

    $.ajax({
        url: '/solicitante_solicitacao/' + id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#solicitanteSolicitacao').text(data[0]['nome']);
        }
    });

    $.ajax({
        url: '/itens_solicitacao_admin/' + id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            var ret = '';
            for (var item in data) {
                ret += "<tr>";
                ret += "<td>" + data[item]['nome'] + "</td>";
                ret += "<td>" + data[item]['descricao'] + "</td>";
                ret += "<td style=\"text-align: center\">" + data[item]['quantidade_solicitada'] + "</td>";
                ret += "</tr>";
            }

            $('#solicitacaoID').val(id);
            $("#tableItens tbody").append(ret);
            $("#overlay").hide();
            $("#modalBody").show();
        }
    });
}

$(function () {
    var table = $('#tableSolicitacoes').DataTable({
        searching: true,
        "language": {
            "search": "Pesquisar:",
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
            "targets": [],
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
                success: function (data) {
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
        $("#modalBody").hide();
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
