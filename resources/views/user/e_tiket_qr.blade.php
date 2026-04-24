<x-app-layout>
    <div class="py-12 min-h-screen" style="background-color: var(--warna-bg-konten)">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            {{-- Card Tiket --}}
            <div class="bg-white rounded-[2rem] shadow-2xl overflow-hidden border-t-[10px] shadow-orange-900/10" style="border-color: var(--warna-utama)">
                <div class="p-8 text-center">
                    <h2 class="text-2xl font-black text-gray-800 uppercase tracking-tighter">E-Tiket Resmi</h2>
                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mb-8">Gate Pass & Check-in System</p>

                    {{-- QR CODE AREA --}}
                    <div class="flex justify-center p-6 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200 mb-8 relative group">
                        <div class="bg-white p-4 rounded-2xl shadow-sm transition-transform group-hover:scale-105 duration-300">
                            {{-- Generate QR Code --}}
@if(!empty($attendee->qr_code))
    {{-- Menggunakan warna hitam (0,0,0) agar sangat kontras dan mudah discan --}}
    {!! QrCode::size(180)
        ->margin(1)
        ->color(0, 0, 0) 
        ->generate($attendee->qr_code) !!}
@else
    <div class="w-[180px] h-[180px] flex items-center justify-center text-red-500 text-[10px] font-bold">
        QR TIDAK TERSEDIA
    </div>
@endif
                        </div>
                    </div>

                    {{-- KODE UNIK --}}
                    <div class="bg-[var(--warna-utama)]/5 py-4 rounded-2xl border border-[var(--warna-utama)]/10 mb-8">
                        <p class="text-[9px] text-gray-400 font-black uppercase tracking-[0.3em] mb-1">Unique Ticket Code</p>
                        <p class="text-xl font-mono font-black text-[var(--warna-utama)] tracking-[0.15em]">
                            {{ $attendee->qr_code ?? 'N/A' }}
                        </p>
                    </div>

                    {{-- INFO EVENT --}}
                    <div class="text-left space-y-5 border-t border-gray-100 pt-8">
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Event Name</p>
                            <p class="font-bold text-gray-800 leading-tight">
                                {{ $attendee->order_detail->tiket->event->nama_event ?? 'Event Tidak Ditemukan' }}
                            </p>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Category</p>
                                <p class="font-bold text-[var(--warna-utama)]">
                                    {{ $attendee->order_detail->tiket->nama_tiket ?? 'Kategori Tidak Ditemukan' }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Status</p>
                                {{-- Menyesuaikan dengan ENUM database: belum_hadir / sudah_hadir --}}
                                @if($attendee->status_kehadiran == 'belum_hadir')
                                    <span class="inline-block font-black text-[10px] uppercase px-3 py-1 rounded-full bg-amber-100 text-amber-600">
                                        Ready to Use
                                    </span>
                                @else
                                    <span class="inline-block font-black text-[10px] uppercase px-3 py-1 rounded-full bg-green-100 text-green-600">
                                        Used/Checked-in
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- FOOTER CARD --}}
                <div class="bg-[var(--warna-sidebar)] p-5 text-center">
                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest leading-relaxed">
                        Valid for one-time entry only. <br> 
                        <span class="text-white/50 italic font-medium lowercase">Keep your QR code private to avoid unauthorized use.</span>
                    </p>
                </div>
            </div>

            {{-- BACK BUTTON --}}
            <div class="mt-8 text-center">
                <a href="{{ route('user.tiket_saya') }}" class="inline-flex items-center gap-2 text-gray-400 text-[10px] font-black uppercase tracking-widest hover:text-[var(--warna-utama)] transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to My Tickets
                </a>
            </div>
        </div>
    </div>
</x-app-layout>