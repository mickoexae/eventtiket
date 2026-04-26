<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight tracking-tight">
                {{ __('Daftar Venue') }}
            </h2>
            <div class="flex gap-2">
                {{-- Tombol Sampah (Hanya muncul jika ada data terhapus) --}}
                @php $trashCount = \App\Models\Venue::onlyTrashed()->count(); @endphp
                @if($trashCount > 0)
                    <a href="{{ route('admin.venue.trash') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-bold text-xs text-gray-600 uppercase tracking-widest hover:bg-gray-200 transition duration-150">
                        🗑️ Sampah ({{ $trashCount }})
                    </a>
                @endif

                <a href="{{ route('admin.venue.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    + Tambah Venue
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-8 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">No</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Nama Venue</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Alamat</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Kapasitas</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-widest">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($venues as $index => $v)
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="font-bold text-gray-900">{{ $v->nama_venue }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $v->alamat }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-700">
                                            {{ number_format($v->kapasitas) }} <span class="text-gray-400 font-normal">Orang</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex justify-center gap-4">
                                                <a href="{{ route('admin.venue.edit', $v->id_venue) }}" class="text-indigo-600 hover:text-indigo-900 font-bold uppercase text-[10px] tracking-widest">
                                                    Edit
                                                </a>
                                                
                                                <button type="button" 
                                                    onclick="confirmDelete('delete-form-{{ $v->id_venue }}')" 
                                                    class="text-red-500 hover:text-red-700 font-bold uppercase text-[10px] tracking-widest">
                                                    Hapus
                                                </button>

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
                                        <td colspan="5" class="px-6 py-20 text-center">
                                            <div class="flex flex-col items-center">
                                                <span class="text-4xl mb-3">📍</span>
                                                <p class="text-gray-400 italic text-sm font-medium">Belum ada data venue yang tersedia.</p>
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
            title: 'Hapus Venue?',
            text: "Data akan dipindahkan ke kotak sampah dan bisa dikembalikan nanti.",
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