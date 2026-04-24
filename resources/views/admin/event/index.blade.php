<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Event') }}
            </h2>
            <a href="{{ route('admin.event.create') }}" class="inline-flex items-center px-5 py-2.5 bg-blue-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:scale-95 transition ease-in-out duration-150 shadow-lg shadow-blue-200">
                + Tambah Event
            </a>
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
                                                     class="h-14 w-20 object-cover rounded-lg shadow-sm"
                                                     alt="Poster">
                                            @else
                                                <div class="h-14 w-20 bg-gray-100 rounded-lg flex items-center justify-center text-[10px] text-gray-400 font-bold uppercase text-center p-1 border border-dashed border-gray-300">
                                                    No Poster
                                                </div>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-black text-gray-900 uppercase tracking-tight">
                                            {{ $e->nama_event }}
                                        </td>
                                        
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                {{ \Carbon\Carbon::parse($e->tanggal_event ?? $e->tanggal)->translatedFormat('d M Y') }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-blue-600">
                                            {{ $e->venue->nama_venue ?? 'Venue tidak ditemukan' }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex justify-center gap-3">
                                                <a href="{{ route('admin.event.edit', $e->id_event) }}" 
                                                   class="text-blue-600 hover:text-blue-800 font-bold uppercase text-xs tracking-tighter">
                                                    Edit
                                                </a>

                                                {{-- Tombol Hapus: Menggunakan variabel $e --}}
                                                <button type="button" 
                                                    onclick="confirmDelete('delete-form-{{ $e->id_event }}')" 
                                                    class="text-red-600 hover:text-red-800 font-bold uppercase text-xs tracking-tighter">
                                                    Hapus
                                                </button>

                                                {{-- Form Hapus: Arahkan ke rute event.destroy --}}
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
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-500 italic font-bold">
                                            Belum ada data event yang terdaftar.
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