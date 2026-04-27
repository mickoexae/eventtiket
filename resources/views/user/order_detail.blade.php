<x-app-layout>
    <div class="py-12 min-h-screen bg-gray-50">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Notifikasi Error/Success --}}
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-xl font-bold shadow-sm">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-xl font-bold shadow-sm">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            {{-- HEADER INFO --}}
            <div class="mb-8 flex justify-between items-end">
                <div>
                    <h2 class="text-4xl font-black uppercase tracking-tighter text-[var(--warna-utama)]">Detail Transaksi</h2>
                    <p class="text-sm font-bold text-gray-400 uppercase tracking-widest mt-1">Invoice ID: #ORD-{{ $order->id_order }}</p>
                </div>
                <a href="{{ route('user.tiket_saya') }}" class="text-[11px] font-black uppercase border-b-2 border-[var(--warna-utama)] text-[var(--warna-utama)] pb-1 hover:text-[var(--warna-sidebar)] hover:border-[var(--warna-sidebar)] transition-all transform hover:-translate-x-1 inline-block">
                    &larr; Ke Tiket Saya
                </a>
            </div>

            {{-- 1. JIKA STATUS PENDING (TAMPILAN PEMBAYARAN) --}}
            @if($order->status == 'pending')
                <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-gray-200/50 p-10 border border-amber-100 relative overflow-hidden">
                    {{-- Dekorasi Background --}}
                    <div class="absolute top-0 right-0 p-10 opacity-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-40 w-40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>

                    <div class="relative z-10 text-center">
                        <div class="w-24 h-24 bg-amber-50 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        
                        <h3 class="text-2xl font-black uppercase text-gray-800 tracking-tight">Menunggu Pembayaran</h3>
                        <p class="text-gray-500 font-medium mt-2">Silakan selesaikan pembayaran untuk mendapatkan E-Tiket</p>
                        
                        <div class="my-10 p-8 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                            <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Total yang harus dibayar</p>
                            <p class="text-5xl font-black text-blue-700 tracking-tighter">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                        </div>

                        <form action="{{ route('user.order.bayar', $order->id_order) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full max-w-md py-5 bg-[var(--warna-utama)] hover:bg-[var(--warna-sidebar)] text-white font-black rounded-2xl shadow-xl shadow-blue-100 transition-all transform active:scale-95 uppercase tracking-widest text-lg">
                                Konfirmasi & Bayar Sekarang
                            </button>
                        </form>
                        
                        <p class="text-[10px] text-gray-400 mt-6 uppercase font-bold tracking-[0.2em]">
                            *Sistem akan memproses tiket otomatis setelah klik tombol di atas
                        </p>
                    </div>
                </div>

            {{-- 2. JIKA STATUS PAID (TAMPILAN E-TIKET) --}}
            @else
                <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 overflow-hidden border border-gray-100">
                    <div class="bg-[var(--warna-utama)] p-6 text-white flex justify-between items-center">
                        <span class="font-black uppercase tracking-widest text-sm">Tiket Anda Sudah Terbit</span>
                        <span class="bg-white/20 px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border border-white/30">Lunas</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 border-b border-gray-100">
                                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400">Informasi Event</th>
                                    <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400">Kode Unik</th>
                                    <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400 text-center">Status Kehadiran</th>
                                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($order->order_details as $detail)
                                    @foreach($detail->attendees as $attendee)
                                    <tr class="hover:bg-blue-50/20 transition-colors group">
                                        <td class="px-8 py-6">
                                            <p class="font-black text-gray-800 uppercase tracking-tight text-lg">
                                                {{ $detail->tiket->nama_tiket }}
                                            </p>
                                            <p class="text-[10px] font-black text-[var(--warna-utama)] uppercase bg-blue-50 inline-block px-2 py-0.5 rounded-md mt-1">
                                                {{ $detail->tiket->event->nama_event }}
                                            </p>
                                        </td>
                                        <td class="px-6 py-6 text-center">
                                            <span class="font-mono text-sm bg-gray-100 px-4 py-1.5 rounded-xl text-gray-600 font-bold border border-gray-200">
                                                {{ $attendee->qr_code }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-6 text-center">
                                            @if($attendee->status_kehadiran == 'sudah_hadir')
                                                <span class="px-4 py-2 rounded-full text-[9px] font-black uppercase bg-green-100 text-green-700 border border-green-200">
                                                    Check-in Berhasil
                                                </span>
                                            @else
                                                <span class="px-4 py-2 rounded-full text-[9px] font-black uppercase bg-amber-100 text-amber-700 border border-amber-200">
                                                    Siap Digunakan
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-8 py-6 text-right">
                                            <a href="{{ route('user.etiket.show', $attendee->qr_code) }}" 
                                               class="inline-flex items-center gap-2 bg-black text-white px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-[var(--warna-utama)] hover:shadow-xl transition-all active:scale-95">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Buka QR
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-8 py-20 text-center">
                                            <p class="text-xs font-black text-gray-400 uppercase tracking-[0.3em]">Data Tiket Belum Di-Generate</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="mt-8 bg-blue-50 p-6 rounded-[1.5rem] border border-blue-100">
                    <div class="flex gap-4 items-center">
                        <div class="bg-blue-600 p-2 rounded-lg text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-black text-blue-900 uppercase tracking-widest">Informasi Penting</p>
                            <p class="text-xs text-blue-700 font-medium leading-relaxed">Harap jangan bagikan Kode Tiket atau QR Code Anda kepada siapapun. Tunjukkan kode unik tersebut kepada petugas di pintu masuk lokasi event.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>