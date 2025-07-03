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
                {{ __('Tambah Data Barang') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('barang.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div>
                            <x-input-label for="nama" :value="__('Nama Barang*')" />
                            <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" value="{{ old('nama') }}" required autocomplete="nama" />
                            <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="kategori" :value="__('Kategori')" />
                            <x-text-input id="kategori" class="block mt-1 w-full" type="text" name="kategori" value="{{ old('kategori') }}" autocomplete="kategori" />
                            <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="harga" :value="__('Harga*')" />
                            <x-text-input id="harga" class="block mt-1 w-full" type="number" min="0" name="harga" value="{{ old('harga') }}" required autocomplete="harga" />
                            <x-input-error :messages="$errors->get('harga')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="stok" :value="__('Stok*')" />
                            <x-text-input id="stok" class="block mt-1 w-full" type="number" min="0" name="stok" value="{{ old('stok') }}" required autocomplete="stok" />
                            <x-input-error :messages="$errors->get('stok')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="image" :value="__('Foto Produk*')" />
                            <img src="{{ asset('images/default-image.jpg') }}" alt="default-image" class="img-thumbnail img-preview" width="100">
                            <input type="file" name="image" id="image" onchange="previewImage()" class="mt-1 block w-full file:py-1 file:px-2 file:rounded-full file:border-0 file:bg-blue-50 file:text-blue-700" accept="image/*" required>
                            <x-input-error class="mt-2" :messages="$errors->get('image')" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-4">
                                {{ __('Tambah') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('script')
        <script src="{{ asset('js/imgpreview.js') }}"></script>
    @endpush
</x-app-layout>

