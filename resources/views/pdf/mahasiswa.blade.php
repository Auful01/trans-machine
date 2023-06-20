<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <table>
        <thead>
            <tr>
                <th>nama</th>
                <th>kelas</th>
                <th>nim</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mahasiswa as $mhs)
                <tr>
                    <td>{{$mhs->user->name}}</td>
                    <td>{{$mhs->kelas->name}}</td>
                    <td>{{$mhs->user->identity_num}}</td>
                </tr>
            @endforeach
    </table>

</body>
</html>
