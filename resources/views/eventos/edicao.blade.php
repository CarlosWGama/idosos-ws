@extends('template')

@section('titulo', 'Edição de Evento')

@section('conteudo')


<div class="card">
    <div class="card-header">
        <strong>Edição</strong>
    </div>

    <form action="{{route('eventos.editar', ['id' => $evento->id])}}" method="post">
        
        <div class="card-body card-block">
            <!-- FORMULARIO -->
            @include('eventos._shared.form')
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