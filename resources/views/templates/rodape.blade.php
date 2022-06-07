<footer class="container-fluid pt-1 pb-4" style="background-color: white">
    <div class="container-fluid px-lg-5">
        <div class="row justify-content-between align-items-center my-2">
            <div class="col-md-4 text-center py-1">
                <a class="navbar-brand mx-3" href="">
                    <img width="80px" src="{{asset('/imagens/logo_pega_pequeno.png')}}">
                </a>
            </div>

            <div class="col-md-4 text-center py-1">
                <div class="form-row">
                    <div class="col-md-12">
                        <h6 style="color: #909090;">Desenvolvido por:</h6>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12" style="margin-bottom: 1rem;">
                        <div class="row justify-content-center" >
                            <div class="col-md-2">
                                <a href="http://ufape.edu.br/" target="_blank"><img src="{{ asset('img/logo_ufape_blue.png') }}" alt="Logo" width="30px;" style="float: right"></a>
                            </div>
                            <div class="col-md-4">
                                <a href="http://lmts.uag.ufrpe.br/" target="_blank"><img src="{{ asset('img/logo_ufape_color.png') }}" alt="Logo" width="160px;" style="border-left: 1px rgba(0, 0, 255, 0.274) solid; padding-left: 15px;"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 text-center pb-4">
                <span class="textoRodape">Redes sociais do lmts</span>
                <div class="row justify-content-center text-center">
                    <a href="https://www.instagram.com/lmts_ufape/" target="_blank" class="col-md-1 p-0"> <img height="30" src="{{asset('img/Icon awesome-instagram.svg')}}"></a>
                    <a href="https://www.facebook.com/LMTSUFAPE/" target="_blank" class="col-md-1 p-0"> <img height="30" src="{{asset('img/Icon awesome-facebook.svg')}}"></a>
                    <a href="mailto:lmts@ufrpe.br" class="col-md-1 p-0"> <img height="30" src="{{asset('img/Icon zocial-email.svg')}}"></a>
                </div>
            </div>
        </div>
        <hr class="m-0 p-0">
    </div>
</footer>

<script>
    $(document).ready(function($) {
        $('#fone').mask('(00)00000-0000');
        $('#fone2').mask('(00)00000-0000');
        $('#cep').mask('00000-000');
        $('#cnpj').mask('00.000.000/0000-00');
        $('#serie').mask('000');
        $('#numero').mask('000.000.000');
        $('#cnpj_emitente').mask('00.000.000/0000-00');
    });
</script>
