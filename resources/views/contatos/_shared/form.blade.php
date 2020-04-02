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

<!-- CAMPO -->
<div class="form-group">
    <div class="input-group">
        <div class="input-group-addon">
            <i class="fa fa-user"></i>
        </div>
        <input type="text" name="campo" value="{{old('campo', $contato->campo)}}" placeholder="Campo: Email, Telefone, Direção..." class="form-control">
    </div>
</div>

<!-- VALOR -->
<div class="form-group">
    <div class="input-group">
        <div class="input-group-addon">
            <i class="fa fa-user"></i>
        </div>
        <input type="text" name="valor" value="{{old('valor', $contato->valor)}}" placeholder="contato@casadopobre.com, 9999-9999..." class="form-control">
    </div>
</div>
