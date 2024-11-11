<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Vtubers</title>
</head>
<body>
    <h1>Lista de Vtubers</h1>
    <a href="/vtubers">+ Criar Novo Vtuber</a>
    @if ($data->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nome</th>
                    <th>Empresa</th>
                    <th>Descrição</th>
                    <th>Imagem</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $vtuber)
                    <tr>
                        <td><a href="/vtubers/{{ $vtuber->id }}">{{ $vtuber->id }}</a></td>
                        <td>{{ $vtuber->name }}</td>
                        <td>{{ $vtuber->empresa }}</td>
                        <td>{{ $vtuber->descricao }}</td>
                        <td>{{ $vtuber->imagem }}</td>
                        <td><a href="/vtuber/{{ $vtuber->id }}">Editar</a></td>
                        <td><a href="/vtuber/{{ $vtuber->id }}/delete">Deletar</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Vtubers não encontrados!</p>
    @endif
</body>
</html>
