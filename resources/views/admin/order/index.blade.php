<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-3">ID Order</th>
                                <th class="px-6 py-3">Nama User</th>
                                <th class="px-6 py-3">Voucher</th>
                                <th class="px-6 py-3">Total Bayar</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($orders as $o)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-bold text-gray-900">#{{ $o->id_order }}</td>
                                
                                {{-- Menampilkan Nama dari kolom 'nama' di tabel users --}}
                                <td class="px-6 py-4 text-gray-600">
                                    {{ $o->user->nama ?? 'Guest' }}
                                </td>
                                
                                {{-- Menampilkan Kode Voucher --}}
                                <td class="px-6 py-4 text-gray-500">
                                    {{ $o->voucher->kode_voucher ?? '-' }}
                                </td>
                                
                                {{-- Menampilkan Total dari kolom 'total' --}}
                                <td class="px-6 py-4 font-bold text-blue-600">
                                    Rp {{ number_format($o->total, 0, ',', '.') }}
                                </td>

                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded-md text-[10px] font-bold uppercase {{ $o->status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $o->status }}
                                    </span>
                                </td>
                                
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('admin.order.destroy', $o->id_order) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 font-bold text-xs uppercase">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center py-10 text-gray-500 italic">Belum ada data transaksi.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>