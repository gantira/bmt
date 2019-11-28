<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Simpanan Report</title>
</head>
<body onload="window.print()">
    <center>
        <h2>Laporan Simpanan</h2>
        BMT
        <p>Periode {{ $periode }} </p>
    </center>
    <br>
    <table border="1" width="100%">
        <thead>
            <tr>
                <th>Nama Nasabah</th>
                <th>Kode Transaksi</th>
                <th>Debit</th>
                <th>Kredit</th>
                <th>Saldo</th>
                <th>Pengelola</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($report as $item)
            <tr>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->kode_transaksi }}</td>
                <td>{{ number_format($item->debit, 2) }}</td>
                <td>{{ number_format($item->kredit, 2) }}</td>
                <td>{{ number_format($item->saldo, 2) }}</td>
                <td>{{ $item->pengelola }}</td>
                <td>{{ $item->tanggal }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>