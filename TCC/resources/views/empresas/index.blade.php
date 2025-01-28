<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empresas</title>
    <script>
        function confirmarExclusao(event) {
            // Exibe uma caixa de confirmação
            if (!confirm('Você tem certeza que deseja excluir esta empresa?')) {
                event.preventDefault(); // Cancela a ação se o usuário cancelar a exclusão
            }
        }
    </script>
</head>
<body>
    <h1>Lista de Empresas</h1>
    <a href="{{ route('empresas.create') }}">+ Criar Nova Empresa</a>

    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if($empresas->count() > 0)
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Localização</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($empresas as $empresa)
                    <tr>
                        <td>{{ $empresa->id }}</td>
                        <td>{{ $empresa->nome }}</td>
                        <td>{{ $empresa->descricao }}</td>
                        <td>{{ $empresa->localizacao }}</td>
                        <td>
                            <a href="{{ route('empresas.show', $empresa->id) }}">Ver</a> |
                            <a href="{{ route('empresas.edit', $empresa->id) }}">Editar</a> |
                            <form action="{{ route('empresas.destroy', $empresa->id) }}" method="POST" style="display:inline;" onsubmit="confirmarExclusao(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Deletar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Nenhuma empresa encontrada!</p>
    @endif
</body>
</html>
