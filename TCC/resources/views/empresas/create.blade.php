<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Empresa</title>
</head>
<body>
    <h1>Criar Nova Empresa</h1>
    <form action="{{ route('empresas.store') }}" method="POST">
        @csrf
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required><br><br>

        <label for="descricao">Descrição:</label>
        <textarea name="descricao" id="descricao"></textarea><br><br>

        <label for="localizacao">Localização:</label>
        <input type="text" name="localizacao" id="localizacao"><br><br>

        <button type="submit">Criar Empresa</button>
    </form>

    <a href="{{ route('empresas.index') }}">Voltar para a lista de empresas</a>
</body>
</html>
