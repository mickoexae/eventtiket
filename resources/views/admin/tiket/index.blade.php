<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight tracking-tight">
                {{ __('Daftar Tiket') }}
            </h2>
            <div class="flex gap-2">
                {{-- Tombol Sampah Tiket --}}
                @php $trashCount = \App\Models\Tiket::onlyTrashed()->count(); @endphp
                @if($trashCount > 0)
                    <a href="{{ route('admin.tiket.trash') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-xl font-bold text-xs text-gray-600 uppercase tracking-widest hover:bg-gray-200 transition duration-150">
                        🗑️ Sampah ({{ $trashCount }})
                    </a>
                @endif

                <a href="{{ route('admin.tiket.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-widest transition active:scale-95 shadow-lg shadow-blue-200">
                    + Tambah Tiket
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 p-8 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Event</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Tiket</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Harga</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Stok</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($tikets as $t)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-4">
                                    @if($t->event && $t->event->trashed())
                                        <div class="flex flex-col">
                                            <span class="text-red-500 font-bold line-through">{{ $t->event->nama_event }}</span>
                                            <span class="text-[10px] text-red-400 font-medium italic">(Event telah dihapus)</span>
                                        </div>
                                    @else
                                        <span class="font-bold text-gray-900 uppercase tracking-tight">{{ $t->event->nama_event ?? 'Tanpa Event' }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-600 font-medium">{{ $t->nama_tiket }}</td>
                                <td class="px-6 py-4 text-green-600 font-black">
                                    Rp {{ number_format($t->harga, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-bold">
                                        {{ $t->stok }} <span class="text-gray-400 font-normal">Sisa</span>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-4">
                                        <a href="{{ route('admin.tiket.edit', $t->id_tiket) }}" class="text-indigo-600 hover:text-indigo-900 font-bold uppercase text-[10px] tracking-widest">
                                            Edit
                                        </a>
                                        
                                        <button type="button" 
                                            onclick="confirmDelete('delete-form-{{ $t->id_tiket }}')" 
                                            class="text-red-500 hover:text-red-700 font-bold uppercase text-[10px] tracking-widest">
                                            Hapus
                                        </button>

                                        <form id="delete-form-{{ $t->id_tiket }}" 
                                              action="{{ route('admin.tiket.destroy', $t->id_tiket) }}" 
                                              method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <span class="text-4xl mb-2">🎫</span>
                                        <p class="italic text-sm font-bold uppercase tracking-widest">Belum ada data tiket.</p>
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
</x-app-layout>

<script>
    function confirmDelete(formId) {
        Swal.fire({
            title: 'Hapus Tiket?',
            text: "Tiket akan dipindahkan ke kotak sampah.",
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