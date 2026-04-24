<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }} - <span class="text-blue-600 capitalize">{{ Auth::user()->role }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- 1. DASHBOARD ADMIN (Laporan Langsung) --}}
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
                        <a href="{{ route('admin.scanner') }}" class="mt-4 inline-block bg-white text-emerald-600 font-bold px-8 py-3 rounded-xl">Buka Kamera Scan</a>
                    </div>
                </div>

            {{-- 3. DASHBOARD USER (Tiket & Voucher) --}}
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                        <div class="p-4 bg-blue-50 text-blue-600 rounded-2xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800">Tiket Saya</h3>
                            <a href="{{ route('user.tiket_saya') }}" class="text-blue-600 font-semibold text-sm hover:underline">Lihat Koleksi Tiket →</a>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                        <div class="p-4 bg-orange-50 text-orange-600 rounded-2xl">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800">Cari Event</h3>
                            <a href="{{ route('user.cari_tiket') }}" class="text-orange-600 font-semibold text-sm hover:underline">Eksplor Sekarang →</a>
                        </div>
                    </div>
                </div>

                {{-- List Voucher --}}
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-6 flex items-center gap-2">
                        <span class="text-xl">🎁</span> Voucher Promo Tersedia
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @forelse($vouchers as $v)
                            <div class="border-2 border-dashed border-red-200 bg-red-50 p-4 rounded-xl text-center group">
                                <p class="text-xs font-bold text-red-500 uppercase tracking-tighter">Potongan Rp {{ number_format($v->potongan, 0, ',', '.') }}</p>
                                <p class="text-xl font-black text-gray-900 my-1">{{ $v->kode_voucher }}</p>
                                <button onclick="alert('Salin kode: {{ $v->kode_voucher }}')" class="text-[10px] text-gray-400 group-hover:text-red-500">Klik untuk salin</button>
                            </div>
                        @empty
                            <p class="col-span-full text-center text-gray-400 italic py-4">Belum ada voucher saat ini.</p>
                        @endforelse
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>