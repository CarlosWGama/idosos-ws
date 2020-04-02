@extends('template')

@section('titulo', 'Edição de Usuário')

@section('conteudo')


<div class="card">
    <div class="card-header">
        <strong>Edição</strong>
    </div>

    <form action="{{route('usuarios.editar', ['id' => $usuario->id])}}" method="post">
        
        <div class="card-body card-block">
            <!-- FORMULARIO -->
            @include('usuarios._shared.form')
            <!-- FORMULARIO -->
        </div>
        
        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fa fa-save"></i> Editar
            </button>
        </div>
    </form>
</div>
@endsection