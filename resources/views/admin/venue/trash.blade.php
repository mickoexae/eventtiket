<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight tracking-tight">
                {{ __('Kotak Sampah: Venue') }}
            </h2>
            <a href="{{ route('admin.venue.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-gray-600 transition duration-150">
                ⬅️ Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-red-100">
                <div class="p-8 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-red-50/50">
                                    <th class="px-6 py-4 text-left text-xs font-bold text-red-600 uppercase tracking-widest">Nama Venue</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-red-600 uppercase tracking-widest">Dihapus Pada</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-red-600 uppercase tracking-widest">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($venues as $v)
                                    <tr class="hover:bg-red-50/30 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="font-bold text-gray-900">{{ $v->nama_venue }}</div>
                                            <div class="text-xs text-gray-400">{{ $v->alamat }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $v->deleted_at->translatedFormat('d M Y, H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex justify-center gap-4">
                                                {{-- Tombol Restore --}}
                                                <form action="{{ route('admin.venue.restore', $v->id_venue) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:text-green-800 font-bold uppercase text-[10px] tracking-widest">
                                                        Restore
                                                    </button>
                                                </form>

                                                {{-- Tombol Hapus Permanen --}}
                                                <button type="button" 
                                                    onclick="confirmForceDelete('force-delete-{{ $v->id_venue }}')" 
                                                    class="text-red-600 hover:text-red-900 font-bold uppercase text-[10px] tracking-widest">
                                                    Hapus Permanen
                                                </button>

                                                <form id="force-delete-{{ $v->id_venue }}" 
                                                      action="{{ route('admin.venue.force-delete', $v->id_venue) }}" 
                                                      method="POST" class="hidden">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-20 text-center">
                                            <div class="flex flex-col items-center text-gray-400">
                                                <span class="text-4xl mb-3">🍃</span>
                                                <p class="italic text-sm font-bold uppercase tracking-widest">Kotak sampah kosong.</p>
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
    function confirmForceDelete(formId) {
        Swal.fire({
            title: 'Hapus Permanen?',
            text: "Data ini tidak akan bisa dikembalikan lagi!",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus Selamanya!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        })
    }
</script>