<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Voucher Diskon') }}
            </h2>
            <a href="{{ route('admin.voucher.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-bold text-xs uppercase transition">
                + Tambah Voucher
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-3">Kode Voucher</th>
                                <th class="px-6 py-3">Potongan</th>
                                <th class="px-6 py-3">Sisa Kuota</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($vouchers as $v)
                                <tr class="hover:bg-gray-50 transition">
                                    {{-- 1. Kode Voucher --}}
                                    <td class="px-6 py-4 font-bold text-gray-900">{{ $v->kode_voucher }}</td>
                                    
                                    {{-- 2. Potongan Harga --}}
                                    <td class="px-6 py-4 text-green-600 font-bold">
                                        Rp {{ number_format($v->potongan, 0, ',', '.') }}
                                    </td>
                                    
                                    {{-- 3. Sisa Kuota --}}
                                    <td class="px-6 py-4 text-gray-600">{{ $v->kuota }}</td>
                                    
                                    {{-- 4. Status Badge --}}
                                    <td class="px-6 py-4">
                                        @if($v->status == 'aktif')
                                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-[10px] font-black uppercase">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-[10px] font-black uppercase">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>

                                    {{-- 5. Aksi (Edit & Hapus) --}}
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-4">
                                            {{-- Link Edit --}}
                                            <a href="{{ route('admin.voucher.edit', $v->id_voucher) }}" 
                                               class="text-blue-600 hover:text-blue-800 font-bold text-xs uppercase tracking-tighter">
                                                Edit
                                            </a>

                                            {{-- Tombol Hapus dengan SweetAlert --}}
                                            <button type="button" 
                                                onclick="confirmDelete('delete-form-{{ $v->id_voucher }}')" 
                                                class="text-red-600 hover:text-red-800 font-bold text-xs uppercase tracking-tighter">
                                                Hapus
                                            </button>

                                            {{-- Form Hapus (Hidden) --}}
                                            <form id="delete-form-{{ $v->id_voucher }}" 
                                                  action="{{ route('admin.voucher.destroy', $v->id_voucher) }}" 
                                                  method="POST" class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            @if($vouchers->isEmpty())
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">
                                        Belum ada data voucher.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>