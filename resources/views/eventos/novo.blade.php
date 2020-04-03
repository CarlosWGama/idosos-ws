@extends('template')

@section('titulo', 'Novo Evento da Agenda')

@section('conteudo')


<div class="card">
    <div class="card-header">
        <strong>Cadastro de Evento da Agenda</strong>
    </div>


    <form action="{{route('eventos.cadastrar')}}" method="post">
        
        <div class="card-body card-block">
            <!-- FORMULARIO -->
            @include('eventos._shared.form')
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