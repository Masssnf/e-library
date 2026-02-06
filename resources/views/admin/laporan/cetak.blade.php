<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Perpustakaan</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
        }

        h2,
        h3 {
            text-align: center;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 8px;
            font-size: 12px;
        }

        th {
            background-color: #f2f2f2;
        }

        .header {
            margin-bottom: 30px;
            text-align: center;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">

    <div class="header">
        <h2>LAPORAN PEMINJAMAN BUKU</h2>
        <h3>PERPUSTAKAAN E-LIBRARY</h3>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} -
            {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Peminjam</th>
                <th>Buku</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $item)
                <tr>
                    <td style="text-align: center">{{ $loop->iteration }}</td>
                    <td>{{ $item->kode_peminjaman }}</td>
                    <td>{{ $item->anggota->nama_anggota }}</td>
                    <td>{{ $item->buku->judul }}</td>
                    <td style="text-align: center">{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') }}</td>
                    <td style="text-align: center">
                        {{ $item->tanggal_pengembalian ? \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d/m/Y') : '-' }}
                    </td>
                    <td style="text-align: center">{{ $item->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px; float: right; text-align: center;">
        <p>Bandung, {{ date('d F Y') }}</p>
        <br><br><br>
        <p><strong>( Admin Perpustakaan )</strong></p>
    </div>

</body>

</html>