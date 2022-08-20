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
});




