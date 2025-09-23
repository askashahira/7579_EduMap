<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #dddddd; text-align: left; padding: 8px; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p>Tanggal Laporan: {{ $date }}</p>
    
    <h3>Data Sekolah</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Sekolah</th>
                <th>Rasio Guru-Murid</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schools as $school)
            <tr>
                <td>{{ $school['id'] }}</td>
                <td>{{ $school['name'] }}</td>
                <td>{{ $school['ratio'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>