$(function () {
    $('#tableOrdemIndex').DataTable({
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
            "targets": [3],
            "orderable": false
        }]
    });

    $('#tableOrdemIndex').on('page.dt', function () {
        $('html, body').animate({
            scrollTop: $(".dataTables_wrapper").offset().top
        }, 'fast');
    });

    $('#tableOrdemIndex').DataTable().columns().iterator('column', function (ctx, idx) {
        $($('#tableOrdemIndex').DataTable().column(idx).header()).append('<span class="sort-icon"/>');
    });

});
