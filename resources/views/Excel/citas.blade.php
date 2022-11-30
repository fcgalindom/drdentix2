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
            <th>N°</th>
            <th>Pacientes</th>
            <th>Documento</th>
            <th>Email</th>
            <th>Telefono</th>
            <th>Odontologo</th>
            <th>Dia</th>
            <th>Hora</th>
            <th>Estado</th>

        </thead>
        <tbody>
            @foreach ($citas as $row)
                <tr>
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->dPacient->name }}</td>
                    <td>{{ $row->dPacient->user->document }}</td>
                    <td>{{ $row->dPacient->user->email }}</td>
                    <td>{{ $row->dPacient->telephone }}</td>
                    <td>{{ $row->denpro->dentists->name }}</td>
                    <td>{{ $row->day}}</td>
                    <td>{{ date("g:i a", strtotime($row->hour)) }}</td>
                    <td>{{ $row->state }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
