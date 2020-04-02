@extends('template')

@section('titulo', 'Novo Contato')

@section('conteudo')


<div class="card">
    <div class="card-header">
        <strong>Cadastro de Contato</strong>
    </div>


    <form action="{{route('contatos.cadastrar')}}" method="post">
        
        <div class="card-body card-block">
            <!-- FORMULARIO -->
            @include('contatos._shared.form')
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