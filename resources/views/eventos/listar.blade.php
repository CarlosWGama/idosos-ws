@extends('template')

@section('titulo', 'Eventos da Agenda')

@section('conteudo')
<div class="user-data m-b-30">
        <h3 class="title-3 m-b-30">
            <i class="zmdi zmdi-account-calendar"></i>Eventos Cadastrados    
        </h3>
        <a href="{{route('eventos.novo')}}" class="btn btn-success btn-sm" style="margin-left:20px">
            <i class="fa fa-add"></i> Inserir Novo Evento na Agenda
        </a>
        
     
        <div class="table-responsive table-data">
                @if(session('sucesso'))
                <div class="alert alert-success" role="alert" style="margin:0px 10px">
                    {{session('sucesso')}}
                </div>
                @endif
            <table class="table">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Dia</td>
                        <td>Autor</td>
                        <td>Descrição</td>
                        <td>Opções</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($eventos as $evento)
                    <tr>
                        <!-- ID -->
                        <td><h6>{{$evento->id}}</h6></td>
                        <!-- DIA -->
                        <td>
                            <div class="table-data__info">
                                @if($evento->recorrente)
                                <h6>Recorrente</h6>
                                @else
                                <h6>{{date('d/m/Y',  strtotime($evento->data))}}</h6>
                                @endif
                            </div>
                        </td>
                        <!-- AUTOR -->
                        <td>
                            <div class="table-data__info">
                                <h6>{{$evento->autor->nome}}</h6>
                            </div>
                        </td>
                        <!-- DESCRICAO -->
                        <td>
                            <div class="table-data__info">
                                <h6>{{$evento->descricao}}</h6>
                            </div>
                        </td>
                        <!-- OPÇÕES -->   
                        <td>
                            <a href="{{route('eventos.edicao', ['id' => $evento->id])}}">
                                <span class="more"><i class="zmdi zmdi-edit"></i></span>
                            </a>
                            <span class="more remover-modal" data-toggle="modal" data-target="#smallmodal" data-id="{{$evento->id}}"><i class="zmdi zmdi-delete"></i></span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
        <!-- Paginação -->
        <div style="padding:10px">{{$eventos->links()}}</div>
        
        </div>
      
    </div>


    @push('javascript')
  <!-- modal small -->
  <div class="modal fade" id="smallmodal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="smallmodalLabel">Remover Evento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                       Deseja Realmente excluir esse evento?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary btn-deletar">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal small -->

    <script>
        let eventoID;
        $('.remover-modal').click(function() {
            eventoID = $(this).data('id');
        })

        $('.btn-deletar').click(() => window.location.href="{{route('eventos.excluir')}}/"+eventoID);
    </script>
@endpush
@endsection