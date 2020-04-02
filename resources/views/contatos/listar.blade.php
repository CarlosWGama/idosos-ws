@extends('template')

@section('titulo', 'Contatos')

@section('conteudo')
<div class="user-data m-b-30">
        <h3 class="title-3 m-b-30">
            <i class="zmdi zmdi-account-calendar"></i>Contatos Cadastrados    
        </h3>
        <a href="{{route('contatos.novo')}}" class="btn btn-success btn-sm" style="margin-left:20px">
            <i class="fa fa-add"></i> Inserir Novo Contato
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
                        <td>Campo</td>
                        <td>Valor</td>
                        <td>Opções</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contatos as $contato)
                    <tr>
                        <!-- ID -->
                        <td><h6>{{$contato->id}}</h6></td>
                        <!-- Campo -->
                        <td>
                            <div class="table-data__info">
                                <h6>{{$contato->campo}}</h6>
                            </div>
                        </td>
                        <!-- Valor -->
                        <td>
                            <div class="table-data__info">
                                <h6>{{$contato->valor}}</h6>
                            </div>
                        </td>
                        <!-- OPÇÕES -->   
                        <td>
                            <a href="{{route('contatos.edicao', ['id' => $contato->id])}}">
                                <span class="more"><i class="zmdi zmdi-edit"></i></span>
                            </a>
                            <span class="more remover-modal" data-toggle="modal" data-target="#smallmodal" data-id="{{$contato->id}}"><i class="zmdi zmdi-delete"></i></span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
        <!-- Paginação -->
        <div style="padding:10px">{{$contatos->links()}}</div>
        
        </div>
      
    </div>


    @push('javascript')
  <!-- modal small -->
  <div class="modal fade" id="smallmodal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="smallmodalLabel">Remover Contato</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                       Deseja Realmente excluir esse contato?
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
        let contatoID;
        $('.remover-modal').click(function() {
            contatoID = $(this).data('id');
        })

        $('.btn-deletar').click(() => window.location.href="{{route('contatos.excluir')}}/"+contatoID);
    </script>
@endpush
@endsection