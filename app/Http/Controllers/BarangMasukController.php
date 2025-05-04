<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barang = Barang::latest()->get();
        return view('barang-masuk.index', compact('barang'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string'
        ]);

        BarangMasuk::create([
            'barang_id' => $data['barang_id'],
            'user_id' => Auth::id(),
            'jumlah' => $data['jumlah'],
            'keterangan' => $data['keterangan'] ?? null,
        ]);

        Barang::where('id', $data['barang_id'])->increment('stok', $data['jumlah']);

        return back()->with('message', 'Stok Berhasil di Tambahkan.');
    }
}
