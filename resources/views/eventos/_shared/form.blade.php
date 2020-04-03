@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


@csrf

<!-- DESCRICAO -->
<div class="form-group">
    <div class="input-group">
        <div class="input-group-addon">
            Descrição
        </div>
        <input type="text" name="descricao" value="{{old('descricao', $evento->campo)}}" placeholder="Adicione uma descrição/título ao evento" class="form-control">
    </div>
</div>

<!-- RECORRENTE -->
<div class="form-group">
    <label class=" form-control-label">Recorrente</label>
    <select name="recorrente" id="select-recorrente" class="form-control">
        <option value="0">Não</option>
        <option value="1" @if(old('recorrente', $evento->recorrente)) selected @endif>Sim</option>
    </select>
    <p class="legenda-form">Uma data recorrente não tem data fixa</p>
</div>

<!-- DATA -->
<div class="form-group" id="data-recorrente" style="display:{{(old('recorrente', $evento->recorrente) ? 'none': 'block')}}">
    <div class="input-group">
        <div class="input-group-addon">
            Data
        </div>
        <input type="date" name="data" value="{{old('data', $evento->data)}}" class="form-control">
    </div>
</div>

<!-- OBSERVAÇÃO -->
<div class="form-group">
    <label for="nf-email" class=" form-control-label">Observação</label>
    <textarea  class="form-control tinymce" name="observacao" rows="3">{{old('observacao', $evento->observacao)}}</textarea>
</div>


@push('javascript')
    <script>
        $('#select-recorrente').change(() => {
            if ($('#select-recorrente').val() == 0) {
                $('#data-recorrente').show('slow');
            } else {
                $('#data-recorrente').hide('slow');
            }
        })
    </script>
@endpush