<nav class="navbar navbar-expand-md navbar-light shadow-sm secundaria-bg">
    <a class="navbar-nav" href="{{ url('/') }}">
        <img src="{{asset('imagens/logo.png')}}" width="170px" style="float: left">
    </a>
    @auth()
        @include('templates.navbar_admin')
    @endauth
</nav>

