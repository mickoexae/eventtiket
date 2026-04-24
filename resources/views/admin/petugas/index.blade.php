<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Petugas') }}
            </h2>
            {{-- Tombol tambah kita hias saja karena kamu pakai seeder --}}
            <button class="bg-gray-400 cursor-not-allowed text-white px-4 py-2 rounded-lg font-bold text-xs uppercase transition" disabled>
                + Tambah via Seeder
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-3">Nama Petugas</th>
                                <th class="px-6 py-3">Email</th>
                                <th class="px-6 py-3">Role</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($petugas as $p)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-bold text-gray-900">{{ $p->nama }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $p->email }}</td>
                                    <td class="px-6 py-4">
                                        <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-[10px] font-black uppercase">
                                            {{ $p->role }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-4">
                                            {{-- Tombol Hapus --}}
                                            <button type="button" 
                                                onclick="confirmDelete('delete-form-{{ $p->id }}')" 
                                                class="text-red-600 hover:text-red-800 font-bold text-xs uppercase tracking-tighter">
                                                Hapus
                                            </button>

                                            {{-- Form Hidden untuk Delete --}}
                                            {{-- Kita pastikan parameter dikirim dalam array agar lebih eksplisit --}}
                                            <form action="{{ route('admin.petugas.destroy', $p->id_user) }}" method="POST" onsubmit="return confirm('Yakin hapus petugas ini?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="text-red-600 font-bold uppercase text-xs">Hapus</button>
</form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-500 italic">
                                        Belum ada data petugas. Silakan jalankan seeder.
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