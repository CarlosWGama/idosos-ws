@extends('template')

@section('titulo', 'Novo Usuário')

@section('conteudo')


<div class="card">
    <div class="card-header">
        <strong>Cadastro de Usuário</strong>
    </div>

    <form action="{{route('usuarios.cadastrar')}}" method="post">
        
        <div class="card-body card-block">
            <!-- FORMULARIO -->
            @include('usuarios._shared.form')
            <!-- FORMULARIO -->
        </div>
        
        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fa fa-save"></i> Cadastrar
            </button>
        </div>
    </form>
</div>
@endsection