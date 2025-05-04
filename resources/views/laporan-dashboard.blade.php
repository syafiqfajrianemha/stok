<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pendapatan</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2>Laporan Pendapatan {{ $filter ? strtoupper(str_replace('_', ' ', $filter)) : '' }}</h2>
    <p>Total Pendapatan: <strong>Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</strong></p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kode Transaksi</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksiFiltered as $transaksi)
                <tr>
                    <td>{{ $transaksi->created_at->format('d M Y H:i') }}</td>
                    <td>{{ $transaksi->kode_transaksi }}</td>
                    <td>Rp{{ number_format($transaksi->total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
