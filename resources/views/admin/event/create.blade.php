<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            Tambah Event Baru
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-8">
                    <form action="{{ route('admin.event.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2">
                                <label for="nama_event" class="block text-sm font-bold text-gray-700 mb-2">Nama Event</label>
                                <input type="text" name="nama_event" id="nama_event" value="{{ old('nama_event') }}" 
                                    class="w-full rounded-xl border-gray-200 focus:ring-blue-500 focus:border-blue-500 shadow-sm" 
                                    placeholder="Contoh: Konser Musik Amal" required>
                                @error('nama_event') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="id_venue" class="block text-sm font-bold text-gray-700 mb-2">Lokasi / Venue</label>
                                <select name="id_venue" id="id_venue" 
                                    class="w-full rounded-xl border-gray-200 focus:ring-blue-500 shadow-sm" required>
                                    <option value="">-- Pilih Venue --</option>
                                    @foreach($venues as $venue)
                                        <option value="{{ $venue->id_venue }}" {{ old('id_venue') == $venue->id_venue ? 'selected' : '' }}>
                                            {{ $venue->nama_venue }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_venue') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="tanggal" class="block text-sm font-bold text-gray-700 mb-2">Tanggal Pelaksanaan</label>
                                <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal') }}"
                                    class="w-full rounded-xl border-gray-200 focus:ring-blue-500 shadow-sm" required>
                                @error('tanggal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="col-span-2">
                                <label for="foto" class="block text-sm font-bold text-gray-700 mb-2">Poster / Foto Event</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-2xl hover:border-blue-400 transition">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="foto" class="relative cursor-pointer bg-white rounded-md font-bold text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                                <span>Upload file</span>
                                                <input id="foto" name="foto" type="file" class="sr-only" accept="image/*" onchange="previewImage(event)">
                                            </label>
                                            <p class="pl-1">atau drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, JPEG hingga 2MB</p>
                                    </div>
                                </div>
                                <img id="output" class="mt-4 rounded-xl hidden max-h-48 mx-auto shadow-md">
                                @error('foto') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.event.index') }}" class="text-sm font-bold text-gray-500 hover:text-gray-700 transition">
                                Batal
                            </a>
                            <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-200 transition transform active:scale-95">
                                Simpan Event
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('output');
                output.src = reader.result;
                output.classList.remove('hidden');
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</x-app-layout>