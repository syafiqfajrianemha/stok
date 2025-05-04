<x-app-layout>
    <div id="flash-data" data-flashdata="{{ session('message') }}"></div>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Input Barang Masuk</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto">
            <form action="{{ route('barang-masuk.store') }}" method="POST" class="bg-white shadow p-6 rounded space-y-4">
                @csrf
                <div class="mt-4">
                    <x-input-label for="barang_id" :value="__('Barang*')" />
                    <x-select-option id="barang_id" class="block mt-1 w-full" name="barang_id" required>
                        <option selected disabled>Pilih Barang</option>
                        @foreach ($barang as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }} (Stok: {{ $item->stok }})</option>
                        @endforeach
                    </x-select-option>
                    <x-input-error :messages="$errors->get('barang_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="jumlah" :value="__('Jumlah Masuk*')" />
                    <x-text-input id="jumlah" class="block mt-1 w-full" type="text" name="jumlah" value="{{ old('jumlah') }}" required autocomplete="jumlah" />
                    <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                </div>

                <div>
                    <label for="keterangan" class="block font-medium">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('keterangan') }}</textarea>
                    <x-input-error :messages="$errors->get('keterangan')" class="mt-2" />
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
            </form>
        </div>
    </div>

    @push('script')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script src="{{ asset('js/main.js') }}"></script>
    @endpush
</x-app-layout>
