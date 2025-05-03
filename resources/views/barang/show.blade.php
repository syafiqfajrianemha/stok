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
                        <p class="text-gray-700">Rp{{ number_format($barang->harga, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Stok Saat Ini</h3>
                        <p class="text-gray-700">{{ $barang->stok }}</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Stok Minimum</h3>
                        <p class="text-gray-700">{{ $barang->stok_minimum }}</p>
                    </div>
                    <div class="border-t pt-4">
                        <h3 class="text-sm text-gray-500">Terakhir diperbarui oleh</h3>
                        <p class="text-gray-700">
                            {{ $barang->user->name ?? 'Tidak diketahui' }}
                            pada {{ $barang->updated_at->translatedFormat('l, d F Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
