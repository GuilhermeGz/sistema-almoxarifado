<nav class="navbar navbar-expand-md navbar-light shadow-sm secundaria-bg">
    <a class="navbar-nav" href="{{ url('/') }}">
        <img src="{{asset('imagens/logo.png')}}" width="170px" style="float: left">
    </a>
    @auth()
        @if(Auth::user()->cargo_id == 1)
            @include('templates.navbar_admin')
        @elseif(Auth::user()->cargo_id == 2)
            @include('templates.navbar_diretoria')
        @elseif(Auth::user()->cargo_id == 3)
            @include('templates.navbar_solicitante')
        @endif
    @endauth
</nav>
