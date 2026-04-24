<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Kehadiran Peserta') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl p-6">
                
                <div class="mb-6">
                    <form action="{{ route('admin.laporan.kehadiran') }}" method="GET" class="flex gap-2">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Cari nama atau email..." 
                               class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <button type="submit" class="bg-gray-800 text-white px-6 py-2 rounded-lg font-bold">
                            Cari
                        </button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-3">Nama Peserta</th>
                                <th class="px-6 py-3">Email</th>
                                <th class="px-6 py-3 text-center">Status</th>
                                <th class="px-6 py-3">Waktu Check-in</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($attendees as $item)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $item->nama_peserta }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $item->email_peserta }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @if($item->status_kehadiran === 'sudah_hadir')
                                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-[10px] font-black uppercase">
                                                Sudah Hadir
                                            </span>
                                        @else
                                            <span class="bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-[10px] font-black uppercase">
                                                Belum Hadir
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 text-xs">
                                        {{ $item->status_kehadiran === 'sudah_hadir' ? $item->updated_at->format('d M Y, H:i') : '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-500 italic">
                                        Data tidak ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $attendees->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>