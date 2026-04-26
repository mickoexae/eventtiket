<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                {{ __('Kotak Sampah: Tiket') }}
            </h2>
            <a href="{{ route('admin.tiket.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-gray-600 transition">
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
                                    <th class="px-6 py-4 text-left text-xs font-bold text-red-600 uppercase">Event</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-red-600 uppercase">Jenis Tiket</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-red-600 uppercase">Harga</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-red-600 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($tikets as $t)
                                    <tr class="hover:bg-red-50/30 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 uppercase">
                                            {{ $t->event->nama_event ?? 'Event Terhapus Permanen' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ $t->nama_tiket }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-mono">
                                            Rp {{ number_format($t->harga, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex justify-center gap-4">
                                                <form action="{{ route('admin.tiket.restore', $t->id_tiket) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:text-green-800 font-bold uppercase text-[10px]">
                                                        Restore
                                                    </button>
                                                </form>

                                                <form action="{{ route('admin.tiket.force-delete', $t->id_tiket) }}" method="POST" onsubmit="return confirm('Hapus tiket ini selamanya?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 font-bold uppercase text-[10px]">
                                                        Force Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-20 text-center">
                                            <p class="italic text-gray-400 uppercase font-bold tracking-widest text-sm">Tidak ada tiket di sampah.</p>
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