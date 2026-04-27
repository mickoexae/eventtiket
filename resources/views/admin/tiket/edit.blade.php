<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">Edit Stok & Harga: {{ $tiket->nama_tiket }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- 1. ALERT PERINGATAN (KAPASITAS VENUE) --}}
            @if(session('error'))
                <div class="mb-6 flex items-center p-4 text-sm text-red-800 border border-red-300 rounded-2xl bg-red-50" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <div>
                        <span class="font-bold uppercase tracking-tight">Gagal Update:</span> {{ session('error') }}
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.tiket.update', $tiket->id_tiket) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <div class="space-y-6">
                        {{-- NAMA TIKET --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Tiket</label>
                            <input type="text" name="nama_tiket" value="{{ old('nama_tiket', $tiket->nama_tiket) }}" class="w-full rounded-xl border-gray-200 focus:ring-blue-500 @error('nama_tiket') border-red-500 @enderror" required>
                            @error('nama_tiket') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            {{-- HARGA --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Harga (Rp)</label>
                                {{-- Ditambah min="1" agar tidak bisa 0 --}}
                                <input type="number" name="harga" value="{{ old('harga', $tiket->harga) }}" min="1" class="w-full rounded-xl border-gray-200 focus:ring-blue-500 @error('harga') border-red-500 @enderror" required>
                                @error('harga') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- STOK --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Stok</label>
                                {{-- Ditambah min="1" agar tidak bisa 0 --}}
                                <input type="number" name="stok" value="{{ old('stok', $tiket->stok) }}" min="1" class="w-full rounded-xl border-gray-200 focus:ring-blue-500 @error('stok') border-red-500 @enderror" required>
                                @error('stok') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex gap-3">
                        <button type="submit" class="flex-1 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg transition-all uppercase tracking-wider">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.tiket.index') }}" class="py-3 px-6 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition uppercase">
                            Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>