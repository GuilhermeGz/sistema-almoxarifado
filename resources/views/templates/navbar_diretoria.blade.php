<ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="textdropdown">Relatório</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{route('relatorio.materiais')}}">
                <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-archive" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                          d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                </svg>
                Consultar</a>
        </div>
    </li>

    <div class="dropdown" onselectstart="return false" style="margin-left: 10px">
        <a id="dropdown_perfil" name="dropdown_perfil" class="dropdown" role="button"
           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="#E14856" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5.52 19c.64-2.2 1.84-3 3.22-3h6.52c1.38 0 2.58.8 3.22 3"/>
                <circle cx="12" cy="10" r="3"/>
                <circle cx="12" cy="12" r="10"/>
            </svg>
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
                Sair</a>
        </div>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</ul>
