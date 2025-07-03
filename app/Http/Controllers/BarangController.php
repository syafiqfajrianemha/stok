<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::latest()->get();
        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'kategori' => 'nullable|string',
            'harga' => 'required|integer',
            'stok' => 'required|integer',
            'image' => 'required|mimes:png,jpg,jpeg',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if ($image->isValid()) {
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('files/images', $image, $imageName);
            }
        }

        $validated['image'] = $imageName;
        $validated['user_id'] = Auth::user()->id;

        Barang::create($validated);

        return redirect(route('barang.index', absolute: false))->with('message', 'Barang Berhasil di Tambahkan');
    }

    public function show(string $id)
    {
        $barang = Barang::with(['masuk.user', 'transaksiItem.transaksi.user'])->findOrFail($id);
        return view('barang.show', compact('barang'));
    }

    public function edit(string $id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'kategori' => 'nullable|string',
            'harga' => 'required|integer',
            'stok' => 'required|integer',
            'image' => 'nullable|mimes:png,jpg,jpeg',
        ]);

        $barang = Barang::findOrFail($id);

        $imageName = $barang->image;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if ($image->isValid()) {
                if ($barang->image && Storage::disk('public')->exists('files/images/' . $barang->image)) {
                    Storage::disk('public')->delete('files/images/' . $barang->image);
                }

                $imageName = time() . '.' . $image->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('files/images', $image, $imageName);
            }
        }

        $validated['image'] = $imageName;
        $validated['user_id'] = Auth::user()->id;

        $barang->update($validated);

        return redirect(route('barang.index', absolute: false))->with('message', 'Barang Berhasil di Edit');
    }

    public function destroy(string $id)
    {
        $barang = Barang::findOrFail($id);
        File::delete('storage/files/images/' . $barang->image);
        $barang->delete();
        return redirect(route('barang.index', absolute: false))->with('message', 'Barang Berhasil di Hapus');
    }
}
