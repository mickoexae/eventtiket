<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">Edit Stok & Harga: {{ $tiket->nama_tiket }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.tiket.update', $tiket->id_tiket) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Tiket</label>
                            <input type="text" name="nama_tiket" value="{{ $tiket->nama_tiket }}" class="w-full rounded-xl border-gray-200 focus:ring-blue-500" required>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Harga (Rp)</label>
                                <input type="number" name="harga" value="{{ $tiket->harga }}" class="w-full rounded-xl border-gray-200 focus:ring-blue-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Stok</label>
                                <input type="number" name="stok" value="{{ $tiket->stok }}" class="w-full rounded-xl border-gray-200 focus:ring-blue-500" required>
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