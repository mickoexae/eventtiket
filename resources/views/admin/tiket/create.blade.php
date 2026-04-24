<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">Tambah Kategori Tiket</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            {{-- Pastikan route action-nya benar, biasanya ke admin.tiket.store --}}
            <form action="{{ route('admin.tiket.store') }}" method="POST">
                @csrf
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    
                    {{-- 1. PILIH EVENT --}}
                    <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Event</label>
                        {{-- Ubah name="event_id" jadi name="id_event" --}}
<select name="id_event" class="w-full p-3 border border-gray-200 rounded-xl" required>
    <option value="">-- Pilih Event --</option>
    @foreach($events as $event)
        <option value="{{ $event->id_event }}">{{ $event->nama_event }}</option>
    @endforeach
</select>
                    </div>

                    <hr class="mb-8 border-gray-100">

                    {{-- 2. BAGIAN KATEGORI TIKET --}}
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-black uppercase text-gray-800 tracking-tight">Kategori Tiket</h3>
                        <button type="button" id="btn-tambah-tiket" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-xs font-bold uppercase rounded-lg transition">
                            <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                            Tambah Kategori
                        </button>
                    </div>

                    {{-- Container tempat baris tiket baru akan muncul --}}
                    <div id="container-tiket" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-5 bg-gray-50 rounded-2xl border border-gray-100 relative">
                            <div>
                                <label class="block text-[10px] font-black uppercase text-gray-400 mb-1">Nama Tiket</label>
                                <input type="text" name="nama_tiket[]" class="w-full rounded-lg border-gray-200 text-sm focus:ring-blue-500" placeholder="Contoh: VIP" required>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase text-gray-400 mb-1">Harga (RP)</label>
                                <input type="number" name="harga[]" class="w-full rounded-lg border-gray-200 text-sm focus:ring-blue-500" placeholder="150000" required>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase text-gray-400 mb-1">Stok/Kuota</label>
                                <input type="number" name="stok[]" class="w-full rounded-lg border-gray-200 text-sm focus:ring-blue-500" placeholder="50" required>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12">
                        <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-2xl shadow-xl shadow-blue-200 transition-all transform active:scale-95 uppercase tracking-widest">
                            Simpan Semua Kategori Tiket
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Script untuk Tambah/Hapus Form --}}
    <script>
        document.getElementById('btn-tambah-tiket').addEventListener('click', function() {
            const container = document.getElementById('container-tiket');
            const newRow = document.createElement('div');
            newRow.className = 'grid grid-cols-1 md:grid-cols-3 gap-4 p-5 bg-gray-50 rounded-2xl border border-gray-100 relative group animate-fade-in mt-4';
            
            newRow.innerHTML = `
                <div>
                    <input type="text" name="nama_tiket[]" class="w-full rounded-lg border-gray-200 text-sm focus:ring-blue-500" placeholder="Nama Tiket" required>
                </div>
                <div>
                    <input type="number" name="harga[]" class="w-full rounded-lg border-gray-200 text-sm focus:ring-blue-500" placeholder="Harga" required>
                </div>
                <div class="flex gap-2">
                    <input type="number" name="stok[]" class="w-full rounded-lg border-gray-200 text-sm focus:ring-blue-500" placeholder="Stok" required>
                    <button type="button" class="btn-hapus-tiket p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
            `;
            container.appendChild(newRow);
        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-hapus-tiket')) {
                const row = e.target.closest('.grid');
                row.remove();
            }
        });
    </script>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</x-app-layout>