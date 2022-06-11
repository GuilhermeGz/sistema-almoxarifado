@extends('templates.principal')

@section('title') Página Inicial @endsection

@section('content')
<div class="container primaria-bg" style=" text-align: center; width: auto; margin: -20px; padding: 200px 20px">
    <h1 class="secundaria" style="align-items: center;">BEM-VINDO(A) {{ Str::upper(Auth::user()->nome) }}!</h1>
</div>
@endsection
