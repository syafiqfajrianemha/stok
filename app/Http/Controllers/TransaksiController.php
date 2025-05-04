<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TransaksiController extends Controller
{
    public function index()
    {
        $barang = Barang::latest()->get();
        return view('transaksi.index', compact('barang'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer|exists:barang,id',
            'items.*.nama' => 'required|string',
            'items.*.harga' => 'required|integer',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        foreach ($data['items'] as $item) {
            $barang = Barang::find($item['id']);

            $stokTersisa = $barang->stok - $item['qty'];
            if ($stokTersisa < $barang->stok_minimum) {
                return response()->json([
                    'message' => "Transaksi ditolak. Jumlah {$barang->nama} melebihi batas minimum stok. Stok saat ini: {$barang->stok}, Minimum: {$barang->stok_minimum}.",
                ], 422);
            }
        }

        $kodeTransaksi = 'TRX' . time();
        $total = collect($data['items'])->sum(fn($item) => $item['harga'] * $item['qty']);

        $transaksi = Transaksi::create([
            'user_id' => Auth::id(),
            'kode_transaksi' => $kodeTransaksi,
            'total' => $total,
        ]);

        foreach ($data['items'] as $item) {
            TransaksiItem::create([
                'transaksi_id' => $transaksi->id,
                'barang_id' => $item['id'],
                'qty' => $item['qty'],
                'harga' => $item['harga'],
                'subtotal' => $item['qty'] * $item['harga'],
            ]);

            Barang::where('id', $item['id'])->decrement('stok', $item['qty']);
        }

        return response()->json([
            'message' => 'Transaksi berhasil disimpan!',
            'redirect' => route('transaksi.struk', $transaksi->id)
        ]);
    }

    public function struk($id)
    {
        $transaksi = Transaksi::with('items.barang', 'user')->findOrFail($id);
        return view('transaksi.struk', compact('transaksi'));
    }

    public function riwayat()
    {
        if (Auth::user()->role === 'admin') {
            $transaksi = Transaksi::with('items.barang')->orderByDesc('created_at')->get();
        } else {
            $transaksi = Transaksi::with('items.barang')->where('user_id', Auth::id())->orderByDesc('created_at')->get();
        }
        return view('transaksi.riwayat', compact('transaksi'));
    }
}
