<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('barang.index') }}" class="text-gray-600 hover:text-gray-800 mr-6">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Data Barang') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-4">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Nama Barang</h3>
                        <p class="text-gray-700">{{ $barang->nama }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Kategori</h3>
                        <p class="text-gray-700">{{ $barang->kategori ?? '-' }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Harga</h3>
                        <p class="text-gray-700">Rp{{ number_format($barang->harga, 0, ',', ',') }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Stok Saat Ini</h3>
                        <p class="text-gray-700">{{ $barang->stok }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Stok Minimum</h3>
                        <p class="text-gray-700">{{ $barang->stok_minimum }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-10 max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800">Riwayat Barang Masuk</h3>
                    <div class="overflow-auto">
                        <table class="min-w-full text-sm text-left border">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="px-4 py-2">Tanggal</th>
                                    <th class="px-4 py-2">Jumlah</th>
                                    <th class="px-4 py-2">Keterangan</th>
                                    <th class="px-4 py-2">Input Oleh</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($barang->masuk as $masuk)
                                    <tr class="border-t">
                                        <td class="px-4 py-2">{{ $masuk->created_at->translatedFormat('l, d F Y H:i') }}</td>
                                        <td class="px-4 py-2">{{ $masuk->jumlah }}</td>
                                        <td class="px-4 py-2">{{ $masuk->keterangan ?? '-' }}</td>
                                        <td class="px-4 py-2">{{ $masuk->user->name ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-2 text-center text-gray-500">Belum ada riwayat masuk</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-10 max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-4">
                    <h3 class="text-lg font-semibold text-gray-800">Riwayat Barang Keluar (Penjualan)</h3>
                    <div class="overflow-auto">
                        <table class="min-w-full text-sm text-left border">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="px-4 py-2">Tanggal</th>
                                    <th class="px-4 py-2">Jumlah</th>
                                    <th class="px-4 py-2">Harga Jual</th>
                                    <th class="px-4 py-2">Kasir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($barang->transaksiItem as $item)
                                    <tr class="border-t">
                                        <td class="px-4 py-2">
                                            {{ $item->transaksi->created_at->translatedFormat('l, d F Y H:i') }}
                                        </td>
                                        <td class="px-4 py-2">{{ $item->qty }}</td>
                                        <td class="px-4 py-2">Rp{{ number_format($item->harga, 0, ',', ',') }}</td>
                                        <td class="px-4 py-2">{{ $item->transaksi->user->name ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-2 text-center text-gray-500">Belum ada riwayat penjualan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
