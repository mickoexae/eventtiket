<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }} - <span class="text-blue-600 capitalize">{{ Auth::user()->role }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- 1. DASHBOARD ADMIN --}}
            @if(Auth::user()->role == 'admin')
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-blue-600">
                        <p class="text-sm font-medium text-gray-500 uppercase">Total Pemasukan</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
                        <p class="text-xs text-green-600 mt-2 font-semibold">Bruto</p>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-emerald-500">
                        <p class="text-sm font-medium text-gray-500 uppercase">Estimasi Untung</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($keuntungan, 0, ',', '.') }}</p>
                        <p class="text-xs text-emerald-600 mt-2 font-semibold">10% Fee</p>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-orange-500">
                        <p class="text-sm font-medium text-gray-500 uppercase">Total Transaksi</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalOrder }} Order</p>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-purple-500">
                        <p class="text-sm font-medium text-gray-500 uppercase">User Terdaftar</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalUser }} Orang</p>
                    </div>
                </div>

            {{-- 2. DASHBOARD PETUGAS --}}
            @elseif(Auth::user()->role == 'petugas')
                <div class="bg-emerald-600 p-8 rounded-2xl shadow-lg text-white flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-2xl">Mode Scanner Aktif</h3>
                        <p class="opacity-90">Silakan lakukan validasi tiket pengunjung.</p>
                        <a href="{{ route('admin.scanner') }}" class="mt-4 inline-block bg-white text-emerald-600 font-bold px-8 py-3 rounded-xl hover:bg-gray-100 transition">Buka Kamera Scan</a>
                    </div>
                </div>

            {{-- 3. DASHBOARD USER --}}
            @else
                {{-- Quick Access Menu --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
                        <div class="p-4 bg-blue-50 text-blue-600 rounded-2xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800">Tiket Saya</h3>
                            <a href="{{ route('user.tiket_saya') }}" class="text-blue-600 font-semibold text-sm hover:underline">Lihat Koleksi Tiket →</a>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition">
                        <div class="p-4 bg-orange-50 text-orange-600 rounded-2xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800">Cari Event</h3>
                            <a href="{{ route('user.cari_tiket') }}" class="text-orange-600 font-semibold text-sm hover:underline">Eksplor Sekarang →</a>
                        </div>
                    </div>
                </div>

                {{-- Section Voucher --}}
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-6 flex items-center gap-2 text-lg">
                        <span>🎁</span> Voucher Promo Terbatas
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @forelse($vouchers->take(3) as $v)
                            @php
                                // Menghitung sisa kuota (asumsi ada kolom kuota di tabel vouchers)
                                $sisa = ($v->kuota ?? 0); 
                            @endphp
                            <div class="relative overflow-hidden border-2 border-dashed border-red-200 bg-red-50 p-6 rounded-2xl text-center group transition-all hover:bg-red-100">
                                
                                {{-- Label Sisa Kuota --}}
                                <div class="absolute top-0 right-0 bg-red-500 text-white text-[9px] font-bold px-3 py-1 rounded-bl-xl uppercase tracking-tighter">
                                    Sisa {{ $sisa }} kuota
                                </div>

                                <p class="text-[10px] font-bold text-red-500 uppercase tracking-widest mb-1 mt-2">Potongan Harga</p>
                                <p class="text-2xl font-black text-gray-900 mb-2">Rp {{ number_format($v->potongan, 0, ',', '.') }}</p>
                                
                                <div class="bg-white border border-red-200 rounded-lg py-1 px-4 inline-block mb-3">
                                    <span class="font-mono font-bold text-red-600 tracking-wider">{{ $v->kode_voucher }}</span>
                                </div>
                                
                                {{-- Progress Bar Sederhana --}}
                                <div class="w-full bg-red-200 h-1.5 rounded-full mb-3 overflow-hidden">
                                    <div class="bg-red-500 h-full transition-all duration-500" style="width: {{ $sisa > 0 ? '65%' : '0%' }}"></div>
                                </div>

                                <button onclick="copyToClipboard('{{ $v->kode_voucher }}')" 
                                        class="text-[11px] font-bold text-gray-400 hover:text-red-600 uppercase transition-colors cursor-pointer">
                                    Klik untuk salin kode
                                </button>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-10">
                                <p class="text-gray-400 italic text-sm">Belum ada voucher yang tersedia saat ini.</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- CTA Sosial Media --}}
                    <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                        <p class="text-gray-600 text-sm">
                            Ingin voucher lainnya? <span class="font-bold text-gray-800">Kunjungi sosial media kami!</span>
                        </p>
                        <div class="flex justify-center gap-6 mt-4">
                            <a href="#" class="text-gray-400 hover:text-pink-600 transition-all transform hover:scale-110">
                                <span class="font-bold text-xs uppercase">Instagram</span>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-black transition-all transform hover:scale-110">
                                <span class="font-bold text-xs uppercase">TikTok</span>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-blue-600 transition-all transform hover:scale-110">
                                <span class="font-bold text-xs uppercase">Facebook</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

    {{-- Elemen Toast --}}
    <div id="copyToast" class="fixed bottom-10 left-1/2 -translate-x-1/2 transform scale-0 opacity-0 transition-all duration-300 z-[99]">
        <div class="bg-gray-900/95 backdrop-blur-sm text-white px-6 py-3 rounded-full shadow-2xl flex items-center gap-3 border border-gray-700">
            <div class="bg-green-500 rounded-full p-1">
                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
            </div>
            <span class="text-sm font-semibold tracking-wide text-white">Kode voucher berhasil disalin!</span>
        </div>
    </div>

    {{-- Script Toast Logic --}}
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                const toast = document.getElementById('copyToast');
                toast.classList.remove('scale-0', 'opacity-0');
                toast.classList.add('scale-100', 'opacity-100');
                setTimeout(() => {
                    toast.classList.remove('scale-100', 'opacity-100');
                    toast.classList.add('scale-0', 'opacity-0');
                }, 2500);
            });
        }
    </script>
</x-app-layout>