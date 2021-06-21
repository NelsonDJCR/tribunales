<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <table border="1">
        <thead>
            <td>Departamento</td>
            <td>Ciudad</td>
            <td>Magistrado</td>
            <td>Tipo de documento</td>
            <td>Cédula de ciudadanía</td>
            <td>Tribunal</td>
            <td>Departamentos de residencia</td>
            <td>Municipio de residencia</td>
            {{-- <td>N° de resolución</td> --}}
            <td>Dirección</td>
            <td>Correo electrónico</td>
            <td>Celular</td>
            <td>Banco</td>
            <td>Tipo de cuenta</td>
            <td>N° de cuenta</td>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    <td>{{ $row->tribunal->departamento->nombre ?? '' }}</td>
                    <td>{{ $row->tribunal->ciudad->nombre ?? '' }}</td>
                    <td>{{ $row->nombre }}</td>
                    <td>{{ $row->tipo_identificacion->nombre ?? ''}}</td>
                    <td>{{ $row->numero_identificacion }}</td>
                    <td>{{ $row->tribunal->nombre ?? '' }}</td>
                    <td>{{ $row->departamento->nombre ?? '' }}</td>
                    <td>{{ $row->ciudad->nombre ?? '' }}</td>
                    <td>{{ $row->direccion }}</td>
                    <td>{{ $row->correo }}</td>
                    <td>{{ $row->telefono }}</td>
                    <td>{{ $row->banco->nombre ?? '' }}</td>
                    <td>{{ $row->tipo_cuenta->nombre ?? '' }}</td>
                    <td>{{ $row->numero_cuenta }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
