@extends('template')

@section('titulo', 'Histórico')

@section('conteudo')


<div class="card">
    <div class="card-header">
        <strong>Histórico</strong>
    </div>

    <form action="{{route('casa.historico.editar')}}" method="post">
        
        <div class="card-body card-block">
            <!-- FORMULARIO -->
            <!-- ERRO -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- SUCESSO -->
            @if(session('sucesso'))
                <div class="alert alert-success" role="alert" style="margin:10px 10px">
                    {{session('sucesso')}}
                </div>
            @endif


            @csrf

           <!-- DESCRICAO -->
            <div class="form-group">
                <label for="nf-email" class=" form-control-label">Informação</label>
                <textarea  class="form-control tinymce" name="descricao" rows="10">{{old('descricao', $historico->descricao)}}</textarea>
            </div>
        </div>
        
        <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fa fa-dot-circle-o"></i> Atualizar
            </button>
        </div>
    </form>
</div>
@endsection
