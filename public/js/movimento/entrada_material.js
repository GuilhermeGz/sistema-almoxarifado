$(function () {
    $('.selectMaterial').select2({
        placeholder: "Digite algo ou selecione uma opção.",
        language: { noResults: () => "Nenhum resultado encontrado.",},
    });

    $('.selectNota').select2({
        placeholder: "Selecione a Nota Fiscal.",
        language: { noResults: () => "Nenhum resultado encontrado.",},
    });
    $('.selectSetor').select2({
        placeholder: "Selecione o Setor.",
        language: { noResults: () => "Nenhum resultado encontrado.",},
    });

    $('#selectMaterial').change(function () {
        $.ajax({
            url: '/notas_material/' + this.value,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#selectNotas').empty();
                var optionsHtml = "";
                data.forEach(function (nota) {
                    $('#selectNotas').append("<option value='" + nota[0] + "'>" + nota[2] + ' - ' + nota[1] + ' -  Faltam[' + nota[3] + ']' + "</option>")
                });
            }
        });
    });
});




