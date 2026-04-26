<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight tracking-tight">
                {{ __('Daftar Event') }}
            </h2>
            <div class="flex gap-2">
                {{-- Tombol Sampah Event (Hanya muncul jika ada data terhapus) --}}
                @php $trashCount = \App\Models\Event::onlyTrashed()->count(); @endphp
                @if($trashCount > 0)
                    <a href="{{ route('admin.event.trash') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-xl font-bold text-xs text-gray-600 uppercase tracking-widest hover:bg-gray-200 transition duration-150">
                        🗑️ Sampah ({{ $trashCount }})
                    </a>
                @endif

                <a href="{{ route('admin.event.create') }}" class="inline-flex items-center px-5 py-2.5 bg-blue-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:scale-95 transition ease-in-out duration-150 shadow-lg shadow-blue-200">
                    + Tambah Event
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Notifikasi Sukses --}}
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-xl shadow-sm flex items-center gap-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-0 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50/50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Poster</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Event</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Lokasi (Venue)</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($events as $index => $e)
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-400">{{ $index + 1 }}</td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($e->foto)
                                                <img src="{{ asset('storage/' . $e->foto) }}" 
                                                     class="h-14 w-20 object-cover rounded-lg shadow-sm border border-gray-100"
                                                     alt="Poster">
                                            @else
                                                <div class="h-14 w-20 bg-gray-50 rounded-lg flex items-center justify-center text-[8px] text-gray-400 font-bold uppercase text-center p-1 border border-dashed border-gray-300">
                                                    No Poster
                                                </div>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-black text-gray-900 uppercase tracking-tight">
                                            {{ $e->nama_event }}
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($e->tanggal_event ?? $e->tanggal)->translatedFormat('d M Y') }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold">
                                            @if($e->venue && $e->venue->trashed())
                                                <div class="flex flex-col">
                                                    <span class="text-red-500 underline decoration-dotted">{{ $e->venue->nama_venue }}</span>
                                                    <span class="text-[10px] text-red-400 font-medium italic italic leading-none">(Venue telah dihapus)</span>
                                                </div>
                                            @else
                                                <span class="text-blue-600">{{ $e->venue->nama_venue ?? 'Venue tidak ditemukan' }}</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex justify-center gap-4">
                                                <a href="{{ route('admin.event.edit', $e->id_event) }}" 
                                                   class="text-blue-600 hover:text-blue-800 font-bold uppercase text-[10px] tracking-wider">
                                                    Edit
                                                </a>

                                                <button type="button" 
                                                    onclick="confirmDelete('delete-form-{{ $e->id_event }}')" 
                                                    class="text-red-500 hover:text-red-700 font-bold uppercase text-[10px] tracking-wider">
                                                    Hapus
                                                </button>

                                                <form id="delete-form-{{ $e->id_event }}" 
                                                      action="{{ route('admin.event.destroy', $e->id_event) }}" 
                                                      method="POST" class="hidden">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-16 text-center">
                                            <div class="flex flex-col items-center">
                                                <span class="text-4xl mb-2">🎫</span>
                                                <p class="text-gray-400 italic text-sm font-bold uppercase tracking-widest">Belum ada data event.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function confirmDelete(formId) {
        Swal.fire({
            title: 'Pindahkan ke Sampah?',
            text: "Event ini akan dinonaktifkan, tapi data tiket terjual tetap aman.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        })
    }
</script>