<x-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="py-12 bg-gray-50 min-h-screen" x-data="checkoutPage()">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-3xl overflow-hidden border border-gray-100">
                
                {{-- HEADER --}}
                <div class="p-8 border-b bg-white flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tighter">Konfirmasi Pemesanan</h2>
                        <p class="text-xs font-bold text-gray-400 mt-1 uppercase tracking-widest">Selesaikan pembayaran untuk tiketmu</p>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-2xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                </div>

                <div class="p-8">
                    {{-- LIST TIKET --}}
                    <div class="mb-8">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Item Tiket Anda</p>
                        <div class="space-y-3">
                            @foreach($selectedTickets as $item)
                            <div class="flex justify-between items-center p-5 bg-gray-50 rounded-2xl border border-gray-100 group hover:border-blue-200 transition-all">
                                <div class="flex items-center gap-4">
                                    <div class="bg-white h-12 w-12 rounded-xl flex items-center justify-center shadow-sm font-black text-blue-600">
                                        {{ $item['qty'] }}x
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-black text-gray-800 uppercase tracking-tight">{{ $item['nama'] }}</h4>
                                        <p class="text-[11px] text-gray-500 font-bold">Harga Satuan: Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <p class="text-sm font-black text-gray-900">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- VOUCHER SECTION --}}
                    <div class="mb-8 p-6 border-2 border-dashed border-gray-200 rounded-3xl bg-gray-50/50">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Punya Kode Voucher?</p>
                        <div class="flex gap-3">
                            <input type="text" x-model="voucherCode" placeholder="CONTOH: PROMO2026" 
                                class="flex-1 bg-white border-gray-200 rounded-xl text-sm py-3 px-4 uppercase font-black font-mono focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-black placeholder-gray-300 transition-all">
                            <button type="button" @click="cekVoucher()" 
                                class="bg-gray-900 text-white text-xs font-black px-8 rounded-xl uppercase hover:bg-black active:scale-95 transition-all shadow-lg shadow-gray-200">
                                Klaim
                            </button>
                        </div>
                        <template x-if="discount > 0">
                            <div class="mt-3 flex items-center gap-2 text-green-600 animate-bounce">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-[11px] font-black uppercase">Voucher Berhasil Terpasang!</span>
                            </div>
                        </template>
                    </div>

                    {{-- RINGKASAN PEMBAYARAN --}}
                    <div class="bg-gray-900 rounded-3xl p-8 text-white shadow-2xl shadow-blue-100 relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 bg-blue-500/10 rounded-full blur-2xl"></div>
                        
                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between items-center text-gray-400">
                                <span class="text-[10px] font-black uppercase tracking-widest">Subtotal</span>
                                <span class="text-sm font-bold">Rp {{ number_format($total_harga, 0, ',', '.') }}</span>
                            </div>
                            <template x-if="discount > 0">
                                <div class="flex justify-between items-center text-green-400">
                                    <span class="text-[10px] font-black uppercase tracking-widest">Diskon Voucher</span>
                                    <span class="text-sm font-bold">- Rp <span x-text="formatRupiah(discount)"></span></span>
                                </div>
                            </template>
                            <div class="pt-4 border-t border-gray-800 flex justify-between items-center">
                                <span class="text-xs font-black uppercase tracking-[0.2em] text-blue-400">Total Akhir</span>
                                <div class="text-right">
                                    <h2 class="text-3xl font-black text-white tracking-tighter">
                                        <span class="text-sm font-medium mr-1">Rp</span><span x-text="formatRupiah(grandTotal)">{{ number_format($total_harga, 0, ',', '.') }}</span>
                                    </h2>
                                </div>
                            </div>
                        </div>

                        {{-- FORM UTAMA --}}
                        <form action="{{ route('user.proses_bayar') }}" method="POST" id="paymentForm">
                            @csrf
                            @foreach($selectedTickets as $item)
                                <input type="hidden" name="jumlah[{{ $item['id_tiket'] }}]" value="{{ $item['qty'] }}">
                            @endforeach

                            {{-- DATA HIDDEN YANG DIKIRIM KE CONTROLLER --}}
                            <input type="hidden" name="total_akhir" :value="grandTotal">
                            <input type="hidden" name="id_voucher" :value="voucherId">

                            <button type="button" @click="confirmPayment()" 
                                class="w-full py-5 bg-blue-600 hover:bg-blue-500 text-white font-black rounded-2xl uppercase tracking-widest shadow-xl shadow-blue-900/20 active:scale-[0.98] transition-all flex items-center justify-center gap-3">
                                <span>Bayar Sekarang</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </form>
                    </div>

                    <p class="text-center text-[10px] text-gray-400 font-bold mt-6 uppercase tracking-widest">
                        Keamanan transaksi terjamin &bull; E-Ticket akan dikirim otomatis
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function checkoutPage() {
            return {
                voucherCode: '',
                voucherId: '',
                discount: 0,
                subtotal: {{ $total_harga }},
                grandTotal: {{ $total_harga }},

                cekVoucher() {
                    if (!this.voucherCode) {
                        Swal.fire({ icon: 'warning', title: 'KODE KOSONG', text: 'Ketik kodenya dulu Micko!', confirmButtonColor: '#1f2937' });
                        return;
                    }
                    
                    fetch("{{ route('user.cek_voucher') }}", {
                        method: "POST",
                        headers: { 
                            "Content-Type": "application/json", 
                            "X-CSRF-TOKEN": "{{ csrf_token() }}" 
                        },
                        body: JSON.stringify({ kode: this.voucherCode })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.valid) {
                            this.discount = data.potongan;
                            this.voucherId = data.id_voucher;
                            this.grandTotal = this.subtotal - this.discount;
                            Swal.fire({ icon: 'success', title: 'BERHASIL!', text: 'Voucher mantap, dapet potongan!', timer: 2000, showConfirmButton: false });
                        } else {
                            this.discount = 0;
                            this.voucherId = '';
                            this.grandTotal = this.subtotal;
                            Swal.fire({ icon: 'error', title: 'Gagal', text: data.pesan, confirmButtonColor: '#ef4444' });
                        }
                    });
                },

                confirmPayment() {
                    Swal.fire({
                        title: 'SUDAH YAKIN?',
                        text: "Total Rp " + this.formatRupiah(this.grandTotal) + " akan diproses.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'YA, BAYAR!',
                        cancelButtonText: 'BATAL',
                        confirmButtonColor: '#2563eb',
                        cancelButtonColor: '#64748b',
                        customClass: {
                            title: 'font-black uppercase tracking-tighter',
                            confirmButton: 'font-black rounded-xl px-8',
                            cancelButton: 'font-black rounded-xl px-8'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'MEMPROSES...',
                                allowOutsideClick: false,
                                didOpen: () => { Swal.showLoading(); }
                            });
                            document.getElementById('paymentForm').submit();
                        }
                    });
                },

                formatRupiah(val) { 
                    return new Intl.NumberFormat('id-ID').format(val); 
                }
            }
        }
    </script>
</x-app-layout>