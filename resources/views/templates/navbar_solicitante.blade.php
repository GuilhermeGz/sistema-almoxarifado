<style>
    .nav-link {
        color: #E14856 !important;
        font-weight: bold;
    }
    .navbar .navbar-nav .nav-link:hover {
        background-color: #ffffff;
    }
    .nav-item {
        margin-left: 5px;
        margin-right: 5px;
    }
</style>
<ul class="navbar-nav ml-auto">
    <div class="collapse navbar-collapse" id="navbarNav">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('solicitar.material') }}">
                <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-file-earmark-text" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z"/>
                    <path d="M9.5 3V0L14 4.5h-3A1.5 1.5 0 0 1 9.5 3z"/>
                    <path fill-rule="evenodd"
                          d="M5 11.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                </svg>
                Solicitar</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('minhas.solicitacoes') }}">
                <svg width="1.2em" height="1.2em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                          d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                    <path fill-rule="evenodd"
                          d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                </svg>
                Minhas Solicitações</a>
        </li>
    </div>

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
