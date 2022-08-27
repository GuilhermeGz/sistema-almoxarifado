<html>
<head>
    <style>
        /** Define the margins of your page **/
        @page {
            margin: 100px 25px;
        }

        header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            height: 50px;
        }

        main {
            position: relative;
            top: 30%;

        }

        .background {
            background-image: url('{{public_path('imagens/logo_prefeitura_back.png')}}');
            background-position: center top;
            background-size: 80% 400px;
            background-repeat: no-repeat;
            height: 550px;
        }

        footer.fixar-rodape {
            bottom: 0;
            left: 0;
            height: 40px;
            position: fixed;
            width: 100%;
        }

        h4 {
            text-align: left;
            margin-left: 75px;
            margin-top: 0px;
            margin-bottom: 0px;
            font-weight: normal;
        }
    </style>
</head>
<body>
<!-- Define header and footer blocks before your content -->
<header>
    <table width="100%">
        <tr>
            <td width="33%"></td>
            <td width="33%" align="center">
                <img src='{{public_path('imagens/logo_prefeitura.png')}}' width="230" height="150px">
            </td>
            <td width="33%"></td>
        </tr>
        <tr>
            <td align="center" colspan="3">
                <span style="font-weight: bolder; font-size: 24px">ALMOXARIFADO CENTRAL</span>
            </td>
        </tr>
        <tr>
            <td align="center" colspan="3">
                <span style="font-weight: bolder; font-size: 24px;">RECIBO</span>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="5px">
            </td>
        </tr>
        <tr>
            <td align="center" colspan="3">
                <span>SOLICITADO VIA OFÍCIO N° 165/2022</span>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="5px">
            </td>
        </tr>
        <tr>
            <td align="center" colspan="3">
                <span><b style="text-transform: uppercase;">{{$solicitante}}</b></span>
            </td>
        </tr>
        <tr>
            <td colspan="3" height="5px">
            </td>
        </tr>
        <tr>
            <td align="center" colspan="3">
                <span>RECEBI DO <b>ALMOXARIFADO DA SAÚDE</b> OS ITENS A BAIXO</span>
            </td>
        </tr>
    </table>
</header>

<!-- Wrap the content of your PDF inside a main tag -->
<main>
    <div class="background" style="text-align: center;">

        @foreach($itens as $item)
            @if($item != '')
                <h4>{{$item}}.</h4>
            @endif
        @endforeach

        <footer class="fixar-rodape">
            <div class="col-sm-1" style="float: left">
                Recebido Por:
            </div>
            <div class="col-sm-1"></div>
            <div class="col-sm-5" style="float: left">
                _________________________
                <br>
                SECRETARIA DA SAÚDE
                <br>
                Garanhuns {{$dia}} de {{$mes}} de {{$ano}}

            </div>
            <div class="col-sm-5" style="float: right">
                _________________________
                <br>
                MARCONI SILVA
                <br>
                GER. DO ALMOXARIFADO DA SAÚDE

            </div>
        </footer>
    </div>
</main>
</body>
</html>
