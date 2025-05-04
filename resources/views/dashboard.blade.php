<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow-sm sm:rounded-lg">
            @if ($barangStokMinimum->count())
                <div class="mb-6 p-4 bg-red-100 border border-red-300 rounded-lg">
                    <h3 class="font-bold text-red-700 mb-2">⚠️ Reminder Stok Minimum</h3>
                    <table class="w-full text-sm table-auto border-collapse">
                        <thead>
                            <tr class="bg-red-200 text-red-800">
                                <th class="border px-2 py-1 text-left">Nama Barang</th>
                                <th class="border px-2 py-1">Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barangStokMinimum as $barang)
                                <tr class="bg-white">
                                    <td class="border px-2 py-1">{{ $barang->nama }}</td>
                                    <td class="border px-2 py-1 text-center">{{ $barang->stok }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <div class="mb-10">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Grafik Pendapatan</h3>
                <canvas id="pendapatanChart" height="120"></canvas>
            </div>

            <form method="GET" class="mb-6">
                <div class="flex flex-wrap items-center gap-4">
                    <select name="filter" class="border rounded px-3 py-2 block w-40">
                        <option selected disabled>Pilih Filter</option>
                        <option value="hari_ini" {{ request('filter') == 'hari_ini' ? 'selected' : '' }}>Hari Ini</option>
                        <option value="minggu_ini" {{ request('filter') == 'minggu_ini' ? 'selected' : '' }}>Minggu Ini</option>
                        <option value="bulan_ini" {{ request('filter') == 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
                        <option value="custom" {{ request('filter') == 'custom' ? 'selected' : '' }}>Custom</option>
                    </select>

                    <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}"
                           class="border rounded px-3 py-2" placeholder="Tanggal Awal">
                    <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}"
                           class="border rounded px-3 py-2" placeholder="Tanggal Akhir">

                    <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Filter
                    </button>

                    <a href="{{ route('dashboard.pdf', request()->all()) }}"
                       target="_blank"
                       class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Cetak PDF
                    </a>
                </div>
            </form>

            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-800">
                    Total Pendapatan:
                    <span class="text-blue-600">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                </h3>
            </div>

            <table class="min-w-full bg-white border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">Tanggal</th>
                        <th class="px-4 py-2 border">Kode Transaksi</th>
                        <th class="px-4 py-2 border">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksiFiltered as $transaksi)
                        <tr>
                            <td class="px-4 py-2 border">{{ $transaksi->created_at->format('d M Y H:i') }}</td>
                            <td class="px-4 py-2 border">{{ $transaksi->kode_transaksi }}</td>
                            <td class="px-4 py-2 border">Rp{{ number_format($transaksi->total, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-2 text-center border text-gray-500">
                                Tidak ada transaksi ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const labels = @json($chartData->keys());
            const data = @json($chartData->values());

            const ctx = document.getElementById('pendapatanChart').getContext('2d');
            const pendapatanChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Pendapatan (Rp)',
                        data: data,
                        backgroundColor: 'rgba(59, 130, 246, 0.7)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>
