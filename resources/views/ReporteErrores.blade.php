<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <table border="1">
        <th>Línea</th>
        <th>Descripción</th>
        <tbody>
            @foreach ($error as $row)
                <tr>
                    <td>{{ $row['linea'] }}</td>
                    <td>{{ $row['message'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
