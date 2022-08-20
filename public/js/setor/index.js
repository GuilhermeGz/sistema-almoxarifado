$(function () {
    $('#tableSetorIndex').DataTable({
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
        "columnDefs": [{
            "targets": [2],
            "orderable": false
        }]
    });

    $('#tableSetorIndex').on('page.dt', function () {
        $('html, body').animate({
            scrollTop: $(".dataTables_wrapper").offset().top
        }, 'fast');
    });

    $('#tableSetorIndex').DataTable().columns().iterator('column', function (ctx, idx) {
        $($('#tableSetorIndex').DataTable().column(idx).header()).append('<span class="sort-icon"/>');
    });

});
