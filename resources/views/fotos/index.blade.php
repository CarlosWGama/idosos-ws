@extends('template')

@section('titulo', 'Fotos')

@push('css')
    #fotos {
        padding: 0px 20px;
    }

    .foto-img {
        max-height: 100px;
    }
@endpush

@section('conteudo')
<div class="user-data m-b-30">
           <!--===============  CADASTRO DE FOTOS  ====================-->            

            <h3 class="title-3 m-b-30">
            <i class="zmdi zmdi-account-calendar"></i>Cadastradas foto</h3>
        
            <form action="{{route('casa.fotos.cadastrar')}}" method="post" enctype="multipart/form-data">
        
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
        
                    <!-- LEGENDA -->
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-camera"></i>
                            </div>
                            <input type="text" name="legenda" required placeholder="Legenda" class="form-control">
                        </div>
                    </div>

                    <div id="fotos">
                        <div class="image-upload-wrap">
                        <input class="file-upload-input" type='file' name="arquivo" onchange="readURL(this);" accept="image/*" />
                        <div class="drag-text">
                            <h3>Arraste ou clique aqui para adicionar sua imagem</h3>
                        </div>
                        </div>
                    
                        <div class="file-upload-content">
                        <img class="file-upload-image" src="#" alt="your image" />
                        <div class="image-title-wrap">
                            <button type="button" onclick="removeUpload()" class="remove-image">Remover <span class="image-title">imagem</span></button>
                        </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa fa-save"></i> Cadastrar
                    </button>
                </div>
            </form>

            <hr/>
            <!--===============  LISTA DE FOTOS  ====================-->            
            <div class="table-responsive table-data">
                <h3 style="padding-left: 10px"><i class="zmdi zmdi-account-calendar"></i>Fotos Cadastradas</h3>
             
            <table class="table">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Legenda</td>
                        <td>Foto</td>
                        <td>Opções</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fotos as $foto)
                    <tr>
                        <!-- ID -->
                        <td><h6>{{$foto->id}}</h6></td>
                        <!-- NOME -->
                        <td>
                            <div class="table-data__info">
                                <h6>{{$foto->legenda}}</h6>
                            </div>
                        </td>
                        <!-- FOTO -->
                        <td>
                           <img src="{{$foto->url}}" class="foto-img"/>
                        </td>
                        <!-- OPÇÕES -->   
                        <td>
                            <span class="more remover-modal" data-toggle="modal" data-target="#smallmodal" data-id="{{$foto->id}}"><i class="zmdi zmdi-delete"></i></span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
        <!-- Paginação -->
        <div style="padding:10px">{{$fotos->links()}}</div>
        
        </div>
      
    </div>


    @push('javascript')
  <!-- modal small -->
  <div class="modal fade" id="smallmodal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="smallmodalLabel">Remover Foto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                       Deseja Realmente excluir essa foto?
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
        let fotoID;
        $('.remover-modal').click(function() {
            fotoID = $(this).data('id');
        })

        $('.btn-deletar').click(() => window.location.href="{{route('casa.fotos.excluir')}}/"+fotoID);
    </script>
@endpush
@endsection