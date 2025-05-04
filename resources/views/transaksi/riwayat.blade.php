<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('transaksi.index') }}" class="text-gray-600 hover:text-gray-800 mr-6">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Riwayat Transaksi</h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-4">
                @forelse ($transaksi as $trx)
                    <div class="border-b py-3">
                        <div class="flex justify-between items-center">
                            <div>
                                <div class="font-semibold">Kode: {{ $trx->kode_transaksi }}</div>
                                <div class="text-sm text-gray-500">{{ $trx->created_at->format('d M Y H:i') }}</div>
                                <div class="text-sm">Total: Rp {{ number_format($trx->total, 0, ',', '.') }}</div>
                            </div>
                            <a href="{{ route('transaksi.struk', $trx->id) }}" class="bg-blue-600 text-white px-3 py-1 rounded">
                                Cetak Ulang
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600">Belum ada transaksi.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
