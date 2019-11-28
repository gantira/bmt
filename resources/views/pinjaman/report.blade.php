<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pinjaman Report</title>
</head>
<body onload="window.print()">
    <center>
        <h2>Laporan Pinjaman</h2>
        BMT
        <p>Periode {{ $periode }} </p>
    </center>
    <br>
    <table border="1" width="100%">
            <thead>
                <tr>
                    <th>Kode Transaksi</th>
                    <th>Nama Nasabah</th>
                    <th>Uang Yang Dipinjam</th>
                    <th>Sudah Dibayar</th>
                    <th>Sisa Pembayaran</th>
                    <th>Durasi /Bulan</th>
                    <th>Tanggal</th>
                    <th>Pengelola</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($report as $row)
                <tr>
                    <td>{{ $row->kode_transaksi }}</td>
                    <td>{{ $row->user->name }}</td>
                    <td>{{ number_format($row->jumlah) }}</td>
                    <td>{{ number_format($row->sudah_bayar) }}</td>
                    <td>{{ number_format($row->sisa_bayar) }}</td>
                    <td>{{ $row->durasi }}x  Rp{{ number_format($row->jumlah / $row->durasi) }}/bln</td>
                    <td>{{ $row->tanggal }}</td>
                    <td>{{ $row->pengelola }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

</body>
</html>