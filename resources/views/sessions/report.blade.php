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
            <th>Fecha</th>
            <th>Tema</th>
            <th>Descripción</th>
            <th>Departamento</th>
            <th>Ciudad</th>
            <th>Magistrado</th>
        </thead>
        <tbody>
            @foreach ($data as $i)
            <tr>
                <td> {{ $i->fecha }}</td>
                <td> {{ $i->tema }}</td>
                <td> {{ $i->descripcion }}</td>
                <td> {{ $i->departamento }}</td>
                <td> {{ $i->ciudad }}</td>
                <td> {{ $i->magistrado }}</td>
            </tr>
            @endforeach
    
        </tbody>
    </table>
</body>
</html>
<script>
    
</script>
   