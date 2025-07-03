<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Struk Transaksi</title>
    <style>
        body {
            font-family: monospace;
            width: 300px;
            margin: auto;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .mb-2 { margin-bottom: 0.5rem; }
        .border-top { border-top: 1px dashed #000; margin: 0.5rem 0; }
        .small { font-size: 12px; }
    </style>
</head>
<body onload="window.print()">
    <div class="text-center mb-2">
        <h2>Toko Pring Wulung</h2>
        <div class="small">Jl. Contoh No. 123, Purwokerto</div>
    </div>

    <div class="border-top"></div>

    <div class="small">
        <strong>Kode:</strong> {{ $transaksi->kode_transaksi }}<br>
        <strong>Tanggal:</strong> {{ $transaksi->created_at->format('d/m/Y H:i') }}<br>
        <strong>Kasir:</strong> {{ $transaksi->user->username ?? '-' }}
    </div>

    <div class="border-top"></div>

    <table width="100%" class="small">
        @foreach ($transaksi->items as $item)
            <tr>
                <td colspan="2">{{ $item->barang->nama }}</td>
            </tr>
            <tr>
                <td>{{ $item->qty }} x {{ number_format($item->harga) }}</td>
                <td class="text-right">Rp {{ number_format($item->subtotal) }}</td>
            </tr>
        @endforeach
    </table>

    <div class="border-top"></div>

    <table width="100%" class="small">
        <tr>
            <td><strong>Total</strong></td>
            <td class="text-right"><strong>Rp {{ number_format($transaksi->total) }}</strong></td>
        </tr>
    </table>

    <div class="text-center border-top small">
        Terima kasih<br>
        Barang yang sudah dibeli tidak dapat dikembalikan
    </div>
</body>
</html>
