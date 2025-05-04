<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Transaksi') }}
            </h2>
            <a href="{{ route('transaksi.riwayat') }}" class="text-sm text-blue-600 underline">Riwayat Transaksi</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Daftar Barang --}}
                        <div>
                            <h3 class="text-lg font-bold mb-2">Daftar Barang</h3>
                            <div class="space-y-2">
                                <div class="mb-4">
                                    <input
                                        type="text"
                                        id="search-barang"
                                        placeholder="Cari barang..."
                                        class="w-full border border-gray-300 rounded px-3 py-2"
                                    >
                                </div>
                                @foreach ($barang as $item)
                                    <div class="barang-item border p-3 rounded flex justify-between items-center" data-nama="{{ strtolower($item->nama) }}">
                                        <div>
                                            <div class="font-semibold">{{ $item->nama }}</div>
                                            <div class="text-sm text-gray-500">Rp {{ number_format($item->harga, 0, ',', ',') }}</div>
                                        </div>
                                        <button
                                            class="bg-blue-500 text-white px-3 py-1 rounded add-to-cart"
                                            data-id="{{ $item->id }}"
                                            data-nama="{{ $item->nama }}"
                                            data-harga="{{ $item->harga }}"
                                            data-stok="{{ $item->stok }}"
                                            data-stok-minimum="{{ $item->stok_minimum }}"
                                        >
                                            Tambah
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Keranjang --}}
                        <div>
                            <h3 class="text-lg font-bold mb-2">Keranjang</h3>
                            <div id="cart" class="space-y-2">
                                <div class="text-gray-500 text-sm">Belum ada barang ditambahkan.</div>
                            </div>
                            <div class="mt-4 border-t pt-2">
                                <strong>Total: </strong>Rp <span id="total">0</span>
                            </div>
                            <button id="btn-simpan" class="bg-green-600 text-white px-4 py-2 rounded mt-4">
                                Simpan Transaksi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        let cart = [];
        const cartElement = document.getElementById('cart');
        const totalElement = document.getElementById('total');

        function renderCart() {
            cartElement.innerHTML = '';
            let total = 0;

            if (cart.length === 0) {
                cartElement.innerHTML = '<div class="text-gray-500 text-sm">Belum ada barang ditambahkan.</div>';
                totalElement.textContent = '0';
                return;
            }

            cart.forEach(item => {
                total += item.harga * item.qty;
                cartElement.innerHTML += `
                    <div class="border p-2 rounded flex justify-between items-center">
                        <div>
                            <div class="font-medium">${item.nama}</div>
                            <div class="text-sm text-gray-500">
                                Rp ${item.harga.toLocaleString()} x ${item.qty} = Rp ${(item.harga * item.qty).toLocaleString()}<br>
                                <span class="text-red-500">Sisa stok tersedia: ${item.stok - item.stokMinimum - item.qty}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-1">
                            <button class="text-white bg-gray-400 hover:bg-gray-500 px-2 rounded decrease-qty" data-id="${item.id}">−</button>
                            <span class="px-2">${item.qty}</span>
                            <button class="text-white bg-gray-400 hover:bg-gray-500 px-2 rounded increase-qty" data-id="${item.id}">+</button>
                        </div>
                    </div>
                `;
            });

            totalElement.textContent = total.toLocaleString();
        }

        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.dataset.id;
                const nama = button.dataset.nama;
                const harga = parseInt(button.dataset.harga);
                const stok = parseInt(button.dataset.stok);
                const stokMinimum = parseInt(button.dataset.stokMinimum);
                const sisaStokTersedia = stok - stokMinimum;

                const existing = cart.find(item => item.id === id);

                if (existing) {
                    if (existing.qty + 1 > sisaStokTersedia) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Stok tidak mencukupi!',
                            text: `Sisa stok tersedia hanya ${sisaStokTersedia}`,
                        });
                        return;
                    }
                    existing.qty += 1;
                } else {
                    if (sisaStokTersedia <= 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Stok tidak mencukupi!',
                            text: `Tidak bisa menambahkan barang ini karena sisa stok tersedia hanya ${sisaStokTersedia}`,
                        });
                        return;
                    }

                    cart.push({ id, nama, harga, qty: 1, stok, stokMinimum });
                }

                renderCart();
            });
        });

        cartElement.addEventListener('click', (e) => {
            const id = e.target.dataset.id;

            if (e.target.classList.contains('increase-qty')) {
                const item = cart.find(item => item.id === id);
                if (item) {
                    const batasQty = item.stok - item.stokMinimum;
                    if (item.qty + 1 > batasQty) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Tidak bisa menambah!',
                            text: `Maksimal pembelian: ${batasQty}.`,
                        });
                        return;
                    }
                    item.qty += 1;
                    renderCart();
                }
            }

            if (e.target.classList.contains('decrease-qty')) {
                const item = cart.find(item => item.id === id);
                if (item) {
                    item.qty -= 1;
                    if (item.qty <= 0) {
                        cart = cart.filter(i => i.id !== id);
                    }
                    renderCart();
                }
            }
        });

        cartElement.addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-from-cart')) {
                const id = e.target.dataset.id;
                cart = cart.filter(item => item.id !== id);
                renderCart();
            }
        });

        const searchInput = document.getElementById('search-barang');
        searchInput.addEventListener('input', function () {
            const keyword = this.value.toLowerCase();
            const items = document.querySelectorAll('.barang-item');

            items.forEach(item => {
                const nama = item.dataset.nama;
                if (nama.includes(keyword)) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });
        });

        document.getElementById('btn-simpan').addEventListener('click', () => {
            if (cart.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Keranjang masih kosong.',
                    showConfirmButton: true,
                });
                return;
            }

            fetch('{{ route("transaksi.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ items: cart })
            })
            .then(async res => {
                const data = await res.json();
                if (!res.ok) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal menyimpan transaksi',
                        text: data.message,
                    });
                    return;
                }

                Swal.fire({
                    icon: 'success',
                    title: data.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = data.redirect;
                });
            });
        });
    </script>
</x-app-layout>
