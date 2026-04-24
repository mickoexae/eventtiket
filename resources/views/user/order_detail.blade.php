<x-app-layout>
    {{-- Bagian Debug: Bisa dihapus jika data sudah muncul dengan benar --}}
    <div class="bg-red-100 p-4 font-mono text-xs">
        Jumlah Detail: {{ $order->order_details->count() }} <br>
        @if($order->order_details->count() > 0)
            Jumlah Attendees: {{ $order->order_details->first()->attendees->count() }}
        @endif
    </div>

    <div class="py-12 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            {{-- HEADER INFO --}}
            <div class="mb-6 flex justify-between items-end">
                <div>
                    <h2 class="text-3xl font-black uppercase tracking-tighter text-[var(--warna-utama)]">Detail E-Tiket</h2>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Nomor Order: #ORD-{{ $order->id_order }}</p>
                </div>
                <a href="{{ route('user.tiket_saya') }}" class="text-[10px] font-black uppercase border-b-2 border-[var(--warna-utama)] text-[var(--warna-utama)] pb-1 hover:text-[var(--warna-sidebar)] hover:border-[var(--warna-sidebar)] transition-all">
                    &larr; Kembali ke Daftar
                </a>
            </div>

            <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 overflow-hidden border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400">Kategori Tiket</th>
                                <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400">Kode Tiket</th>
                                <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400 text-center">Status</th>
                                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-gray-400 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            {{-- Looping Detail Order --}}
                            @forelse($order->order_details ?? [] as $detail)
                                {{-- Looping Attendee (QR Code) --}}
                                @forelse($detail->attendees ?? [] as $attendee)
                                <tr class="hover:bg-gray-50/50 transition-colors group">
                                    <td class="px-8 py-6">
                                        <p class="font-black text-gray-800 uppercase tracking-tight">
                                            {{ $detail->tiket->nama_tiket ?? 'N/A' }}
                                        </p>
                                        <p class="text-[10px] font-bold text-[var(--warna-utama)] uppercase">
                                            {{ $detail->tiket->event->nama_event ?? 'Event' }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-6">
                                        {{-- Menampilkan qr_code sesuai database --}}
                                        <span class="font-mono text-sm bg-gray-100 px-3 py-1 rounded-lg text-gray-600 font-bold italic">
                                            {{ $attendee->qr_code }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-6 text-center">
                                        {{-- Cek status berdasarkan ENUM: belum_hadir / sudah_hadir --}}
                                        @if($attendee->status_kehadiran == 'sudah_hadir')
                                            <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase bg-green-100 text-green-700 border border-green-200">
                                                Sudah Hadir
                                            </span>
                                        @else
                                            <span class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase bg-amber-100 text-amber-700 border border-amber-200">
                                                Belum Hadir
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        {{-- Link ke halaman QR menggunakan qr_code --}}
                                        <a href="{{ route('user.etiket.show', $attendee->qr_code) }}" 
                                           class="inline-flex items-center gap-2 bg-[var(--warna-utama)] text-white px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-[var(--warna-sidebar)] hover:shadow-lg transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Lihat QR
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                    {{-- Muncul jika ada detail order tapi data attendee kosong di DB --}}
                                @endforelse
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-20 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <p class="text-xs font-black text-gray-400 uppercase tracking-[0.3em]">Data Tiket Tidak Ditemukan</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <p class="mt-6 text-center text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                Tunjukkan QR Code di atas kepada petugas di lokasi event
            </p>
        </div>
    </div>
</x-app-layout>