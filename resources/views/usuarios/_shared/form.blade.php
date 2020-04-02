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

<!-- NOME -->
<div class="form-group">
    <div class="input-group">
        <div class="input-group-addon">
            <i class="fa fa-user"></i>
        </div>
        <input type="text" id="username" name="nome" value="{{old('nome', $usuario->nome)}}" placeholder="Nome" class="form-control">
    </div>
</div>

<!-- SENHA -->
<div class="form-group">
    <div class="input-group">
        <div class="input-group-addon">
            <i class="fa fa-asterisk"></i>
        </div>
        <input type="password" id="password" name="senha" placeholder="Senha" class="form-control">
    </div>
</div>

<!-- ADMINISTRADOR -->
<div class="form-group">
    <label class=" form-control-label">Administrador</label>
    <select name="admin" id="select" class="form-control">
        <option value="0">Não</option>
        <option value="1" @if(old('admin', $usuario->admin)) selected @endif>Sim</option>
    </select>
    <p class="legenda-form">Um usuário administrador pode acessar o gerenciador do aplicativo *</p>
</div>

<!-- PROFISSÃO -->
<div class="form-group">
    <label class=" form-control-label">Profissão</label>
    <select name="profissao_id" id="select" class="form-control">
        @foreach($profissoes as $profissao)
        <option value="{{$profissao->id}}" @if(old('profissao_id', $usuario->profissao_id) == $profissao->id) selected @endif>{{$profissao->nome}}</option>
        @endforeach
    </select>
</div>

<!-- Nivel de Acesso -->
<div class="form-group">
    <label for="nf-email" class=" form-control-label">Nivel de Acesso</label>
    <select name="nivel_acesso" id="select" class="form-control">
        <option value="1" @if(old('nivel_acesso', $usuario->nivel_acesso) == 1) selected @endif>Professor</option>
        <option value="2" @if(old('nivel_acesso', $usuario->nivel_acesso) == 2) selected @endif>Monitor</option>
        <option value="3" @if(old('nivel_acesso', $usuario->nivel_acesso) == 3) selected @endif>Aluno</option>
    </select>
    <p class="legenda-form">Professor tem acesso total ao paciente e pode montar equipes com alunos e monitores.</p>
    <p class="legenda-form">Monitores tem acesso total ao paciente.</p>
    <p class="legenda-form">Aluno tem acesso limitado ao paciente</p>

</div>
