<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight tracking-tight">
                {{ __('Kotak Sampah: Event') }}
            </h2>
            <a href="{{ route('admin.event.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-gray-600 transition duration-150">
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
                                    <th class="px-6 py-4 text-left text-xs font-bold text-red-600 uppercase tracking-widest">Event</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-red-600 uppercase tracking-widest">Venue</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-red-600 uppercase tracking-widest">Dihapus Pada</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-red-600 uppercase tracking-widest">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($events as $e)
                                    <tr class="hover:bg-red-50/30 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if($e->foto)
                                                    <img src="{{ asset('storage/' . $e->foto) }}" class="w-10 h-10 rounded-lg object-cover mr-3 grayscale">
                                                @endif
                                                <div class="font-bold text-gray-900 uppercase italic">{{ $e->nama_event }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">
                                            {{ $e->venue->nama_venue ?? 'Venue Tidak Ada' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                            {{ $e->deleted_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex justify-center gap-4">
                                                {{-- Tombol Restore --}}
                                                <form action="{{ route('admin.event.restore', $e->id_event) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:text-green-800 font-bold uppercase text-[10px] tracking-widest">
                                                        Restore
                                                    </button>
                                                </form>

                                                {{-- Tombol Hapus Permanen --}}
                                                <form action="{{ route('admin.event.force-delete', $e->id_event) }}" method="POST" onsubmit="return confirm('Hapus permanen? Data tidak bisa balik lagi!')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 font-bold uppercase text-[10px] tracking-widest">
                                                        Permanent Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-20 text-center">
                                            <div class="flex flex-col items-center text-gray-400">
                                                <span class="text-4xl mb-3">📭</span>
                                                <p class="italic text-sm font-bold uppercase tracking-widest">Tidak ada event di sampah.</p>
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