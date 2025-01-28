<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Empresa</title>
</head>
<body>
    <h1>{{ $empresa->nome }}</h1>
    <p><strong>Descrição:</strong> {{ $empresa->descricao }}</p>
    <p><strong>Localização:</strong> {{ $empresa->localizacao }}</p>

    <a href="{{ route('empresas.index') }}">Voltar para a lista de empresas</a>
</body>
</html>
