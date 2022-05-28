<div id="app">
    <nav class="navbar navbar-expand-md navbar-light shadow-sm" style="background-color: #3E3767;">
        <div class="container">

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                </ul>
                <ul class="navbar-nav ml-auto">
                    <a class="nav-link menuSupEInf" style="color: white; font-weight: bold" href="{{ route('home') }}">
                        <li class="nav-item " style="padding: 0px 15px">
                            {{ __('Início') }}
                        </li>
                    </a>
                    <a class="nav-link menuSupEInf" style="color: white; font-weight: bold"
                       href="{{ route('sistema') }}">
                        <li class="nav-item " style="padding: 0px 15px">
                            {{ __('O Sistema') }}
                        </li>
                    </a>
                    <a class="nav-link menuSupEInf" style="color: white; font-weight: bold"
                       href="{{ route('parceria') }}">
                        <li class="nav-item " style="padding: 0px 15px">
                            {{ __('A Parceria') }}
                        </li>
                    </a>
                    <a class="nav-link menuSupEInf" style="color: white; font-weight: bold"
                       href="{{ route('contato') }}">
                        <li class="nav-item " style="padding: 0px 15px">
                            {{ __('Contato') }}
                        </li>
                    </a>

                    @if(!empty(Auth::user()->id) and Auth::user()->cargo_id == 1)
                        @php
                            $notificacoes = Illuminate\Support\Facades\DB::table('notificacaos')->where('usuario_id', '=', Auth::user()->id)->paginate(5);
                            $notNaoVistas = false;
                            for($i=0; $i < count($notificacoes); $i++){
                                if($notificacoes[$i]->visto == false){
                                    $notNaoVistas = true;
                                    break;
                                }
                            }
                        @endphp
                        <div class="dropdown" style="padding-right: 10px" onselectstart="return false">
                            <a id="dropdown_notificacao" name="dropdown_perfil" class="nav-link menuSupEInf"
                               role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white">
                                <li class="dropdown-toggle nav-item " style="padding: 0px 15px">
                                    @if($notNaoVistas == true)
                                        <b style="color: #ffbe0b">Notificações</b>
                                    @else
                                        <b>Notificações</b>
                                    @endif
                                </li>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown_notificacao">
                                @foreach($notificacoes as $notificacao)
                                    @if($notificacao->visto == false)

                                        <a class="dropdown-item text-danger"
                                           href="{{route('notificacao.show', ['notificacao_id' => $notificacao->id])}}" style="text-align: center">{{$notificacao->mensagem}}</a>
                                        <hr style="margin: 0px; padding: 0px">
                                    @endif

                                @endforeach
                                <a class="dropdown-item" href="{{route('notificacao.index')}}" style="text-align: center">Ver todas as
                                    notificações.</a>
                            </div>
                        </div>
                    @endif

                    @if(!empty(Auth::user()->id))
                        <div class="dropdown" onselectstart="return false" style="margin-left: 10px">
                            <a id="dropdown_perfil" name="dropdown_perfil" class="dropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                               <img src="{{asset('imagens/logo_pega_pequeno.png')}}" style="width:35px"/>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown_perfil">
                                <a class="dropdown-item"
                                   href="{{ route('usuario.edit_perfil', ['id' => Auth::user()->id]) }}"> Editar
                                    Perfil </a>
                                <a class="dropdown-item"
                                   href="{{ route('usuario.edit_senha', ['id' => Auth::user()->id]) }}"> Editar
                                    Senha </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); sessionStorage.clear(); document.getElementById('logout-form').submit();">
                                    Sair </a>
                            </div>
                        </div>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</div>
