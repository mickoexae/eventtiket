<x-app-layout>
    {{-- SweetAlert2 CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Menghilangkan panah di input number agar lebih rapi */
        .compact-input::-webkit-inner-spin-button, 
        .compact-input::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
    </style>

    <div class="py-4" x-data="cartSystem()">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-200">
                
                <div class="flex flex-col md:flex-row">
                    {{-- SISI KIRI: POSTER EVENT --}}
                    <div class="md:w-1/3 bg-gray-100 border-r">
                        @if($event->foto)
                            <img src="{{ asset('storage/' . $event->foto) }}" 
                                 class="w-full h-48 md:h-full object-cover"
                                 style="max-height: 450px;">
                        @else
                            <div class="w-full h-48 md:h-full flex items-center justify-center bg-gray-200 text-gray-400 font-bold uppercase">
                                No Poster
                            </div>
                        @endif
                    </div>

                    {{-- SISI KANAN: INFO & PEMILIHAN TIKET --}}
                    <div class="md:w-2/3 p-6 flex flex-col justify-between">
                        <div>
                            {{-- Header Info --}}
                            <div class="mb-4">
                                <h1 class="text-2xl font-black text-gray-900 leading-tight uppercase tracking-tighter">
                                    {{ $event->nama_event }}
                                </h1>
                                <div class="flex flex-wrap gap-4 mt-2 text-[11px] font-bold text-blue-600 uppercase">
                                    <span class="flex items-center">
                                        <i class="fas fa-calendar-alt mr-1.5"></i> 
                                        {{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d F Y') }}
                                    </span>
                                    <span class="flex items-center">
                                        <i class="fas fa-map-marker-alt mr-1.5"></i> 
                                        {{ $event->venue->nama_venue }}
                                    </span>
                                </div>
                            </div>

                            <form action="{{ route('user.checkout_multiple') }}" method="POST" id="checkoutForm">
                                @csrf
                                {{-- SCROLLBOX TIKET --}}
                                <div class="space-y-2 max-h-64 overflow-y-auto pr-2 custom-scrollbar">
                                    @foreach($event->tikets as $t)
                                    <div class="flex justify-between items-center p-3 border border-gray-100 rounded-xl bg-gray-50 hover:bg-white hover:border-blue-300 transition-all group">
                                        <div>
                                            <h4 class="text-sm font-black text-gray-800 group-hover:text-blue-600">{{ $t->nama_tiket }}</h4>
                                            <p class="text-blue-600 font-black text-sm">Rp {{ number_format($t->harga, 0, ',', '.') }}</p>
                                            {{-- PERBAIKAN: Ganti kuota jadi stok --}}
                                            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Sisa: {{ $t->stok }}</span>
                                        </div>

                                        {{-- Input Counter --}}
                                        <div class="flex items-center gap-2 bg-white border border-gray-200 rounded-lg p-1 shadow-sm">
                                            <button type="button" 
                                                @click="updateQty('{{ $t->id_tiket }}', -1, {{ $t->harga }})"
                                                class="w-8 h-8 flex items-center justify-center bg-gray-50 text-gray-800 rounded-md font-black hover:bg-red-500 hover:text-white transition-all text-lg">-</button>
                                            
                                            <input type="number" 
                                                name="jumlah[{{ $t->id_tiket }}]" 
                                                x-model="items['{{ $t->id_tiket }}']"
                                                class="w-8 text-center border-none p-0 font-black text-sm text-gray-900 focus:ring-0 compact-input" 
                                                readonly>
                                            
                                            <button type="button" 
                                                {{-- PERBAIKAN: Parameter kuota ganti jadi stok --}}
                                                @click="updateQty('{{ $t->id_tiket }}', 1, {{ $t->harga }}, {{ $t->stok }})"
                                                class="w-8 h-8 flex items-center justify-center bg-blue-600 text-white rounded-md font-black hover:bg-blue-700 transition-all text-lg shadow-sm">+</button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>

                                {{-- SUMMARY BOX --}}
                                <div class="mt-6 p-5 bg-gray-900 rounded-2xl text-white relative overflow-hidden">
                                    <div class="flex justify-between items-end mb-4 gap-4">
                                        <div class="flex-1">
                                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Kode Voucher</p>
                                            <div class="flex gap-2">
                                                <input type="text" x-model="voucherCode" placeholder="KODE" 
                                                    class="flex-1 bg-gray-800 border-none rounded-lg text-xs py-2 px-3 uppercase font-mono text-white focus:ring-1 focus:ring-blue-500">
                                                <button type="button" @click="cekVoucher()" 
                                                    class="bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-black px-4 rounded-lg transition-all">CEK</button>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Bayar</p>
                                            <h2 class="text-2xl font-black leading-none">
                                                <span class="text-sm text-blue-500">Rp</span> <span x-text="formatRupiah(grandTotal)">0</span>
                                            </h2>
                                            <template x-if="discount > 0">
                                                <p class="text-[10px] text-green-400 font-bold mt-1">Potongan: -Rp <span x-text="formatRupiah(discount)">0</span></p>
                                            </template>
                                        </div>
                                    </div>
                                    
                                    <button type="button" 
                                        @click="confirmCheckout()"
                                        :disabled="grandTotal == 0"
                                        :class="grandTotal == 0 ? 'bg-gray-800 text-gray-600 cursor-not-allowed' : 'bg-white text-gray-900 hover:bg-blue-500 hover:text-white'"
                                        class="w-full py-3 rounded-xl font-black text-sm uppercase tracking-widest transition-all transform active:scale-95 shadow-xl">
                                        Checkout Sekarang
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- SCRIPT LOGIKA --}}
    <script>
        function cartSystem() {
            return {
                items: {}, 
                grandTotal: 0,
                voucherCode: '',
                discount: 0,
                rawTotal: 0,

                init() {
                    @foreach($event->tikets as $t)
                        this.items['{{ $t->id_tiket }}'] = 0;
                    @endforeach
                },

                updateQty(id, delta, harga, max) {
                    let current = parseInt(this.items[id]);
                    let next = current + delta;
                    // Logika validasi stok (max diambil dari $t->stok)
                    if (next >= 0 && (delta < 0 || next <= max)) {
                        this.items[id] = next;
                        this.calculateTotal();
                    } else if (next > max) {
                        Swal.fire({ icon: 'error', title: 'Stok Terbatas', text: 'Maaf, sisa tiket tidak mencukupi.', timer: 1500, showConfirmButton: false });
                    }
                },

                calculateTotal() {
                    let total = 0;
                    @foreach($event->tikets as $t)
                        total += (this.items['{{ $t->id_tiket }}'] * {{ $t->harga }});
                    @endforeach
                    this.rawTotal = total;
                    this.grandTotal = Math.max(0, total - this.discount);
                },

                cekVoucher() {
                    if (!this.voucherCode) {
                        Swal.fire({ icon: 'warning', title: 'Oops!', text: 'Isi kode voucher dulu.', confirmButtonColor: '#3b82f6' });
                        return;
                    }
                    fetch("{{ route('user.cek_voucher') }}", {
                        method: "POST",
                        headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                        body: JSON.stringify({ kode: this.voucherCode, total_sekarang: this.rawTotal })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.valid) {
                            this.discount = data.potongan;
                            this.calculateTotal();
                            Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Voucher terpasang!', timer: 1500, showConfirmButton: false });
                        } else {
                            this.discount = 0;
                            this.calculateTotal();
                            Swal.fire({ icon: 'error', title: 'Gagal', text: data.pesan, confirmButtonColor: '#ef4444' });
                        }
                    });
                },

                confirmCheckout() {
                    Swal.fire({
                        title: 'Konfirmasi Pesanan',
                        text: "Total bayar: Rp " + this.formatRupiah(this.grandTotal),
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#2563eb',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Ya, Checkout!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('checkoutForm').submit();
                        }
                    });
                },

                formatRupiah(a) {
                    return new Intl.NumberFormat('id-ID').format(a);
                }
            }
        }
    </script>
</x-app-layout>