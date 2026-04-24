<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Tiket</h2>
            <a href="{{ route('admin.tiket.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-xs font-bold uppercase transition">+ Tambah Tiket</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 p-6 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Event</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Nama Tiket</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase">Stok</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($tikets as $t)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-bold text-gray-900">{{ $t->event->nama_event }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $t->nama_tiket }}</td>
                            <td class="px-6 py-4 text-green-600 font-bold">Rp {{ number_format($t->harga, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $t->stok }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-4">
                                    {{-- Edit --}}
                                    <a href="{{ route('admin.tiket.edit', $t->id_tiket) }}" class="text-indigo-600 hover:text-indigo-900 font-bold uppercase text-xs">Edit</a>
                                    
                                    {{-- Tombol Hapus: Menggunakan $t->id_tiket --}}
                                    <button type="button" 
                                        onclick="confirmDelete('delete-form-{{ $t->id_tiket }}')" 
                                        class="text-red-600 hover:text-red-900 font-bold uppercase text-xs">
                                        Hapus
                                    </button>

                                    {{-- Form Hapus: Arahkan ke rute tiket.destroy --}}
                                    <form id="delete-form-{{ $t->id_tiket }}" 
                                          action="{{ route('admin.tiket.destroy', $t->id_tiket) }}" 
                                          method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                        @if($tikets->isEmpty())
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">Belum ada data tiket.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>