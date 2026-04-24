<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Venue') }}
            </h2>
            <a href="{{ route('admin.venue.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                + Tambah Venue
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Notifikasi Sukses Manual (Opsional karena sudah ada SweetAlert otomatis di app.blade) --}}
            @if(session('success') && !request()->ajax())
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Venue</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alamat</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kapasitas</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($venues as $index => $v)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $v->nama_venue }}</td>
                                        <td class="px-6 py-4">{{ $v->alamat }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($v->kapasitas) }} Orang</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex justify-center gap-3">
                                                {{-- Link Edit --}}
                                                <a href="{{ route('admin.venue.edit', $v->id_venue) }}" class="text-indigo-600 hover:text-indigo-900 font-bold uppercase text-xs">
                                                    Edit
                                                </a>
                                                
                                                {{-- Tombol Hapus: Menggunakan variabel $v dan id_venue --}}
                                                <button type="button" 
                                                    onclick="confirmDelete('delete-form-{{ $v->id_venue }}')" 
                                                    class="text-red-600 hover:text-red-900 font-bold uppercase text-xs">
                                                    Hapus
                                                </button>

                                                {{-- Form Hapus: Arahkan ke rute venue.destroy --}}
                                                <form id="delete-form-{{ $v->id_venue }}" 
                                                      action="{{ route('admin.venue.destroy', $v->id_venue) }}" 
                                                      method="POST" class="hidden">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">
                                            Belum ada data venue.
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