<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empresa</title>
</head>
<body>
    <h1>Editar Empresa: {{ $empresa->nome }}</h1>
    <form action="{{ route('empresas.update', $empresa->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="{{ $empresa->nome }}" required><br><br>

        <label for="descricao">Descrição:</label>
        <textarea name="descricao" id="descricao">{{ $empresa->descricao }}</textarea><br><br>

        <label for="localizacao">Localização:</label>
        <input type="text" name="localizacao" id="localizacao" value="{{ $empresa->localizacao }}"><br><br>

        <button type="submit">Salvar Alterações</button>
    </form>

    <a href="{{ route('empresas.index') }}">Voltar para a lista de empresas</a>
</body>
</html>
