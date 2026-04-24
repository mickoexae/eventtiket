<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            {{ __('Edit Event') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-8">
                    <form action="{{ route('admin.event.update', $event->id_event) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2">
                                <label for="nama_event" class="block text-sm font-bold text-gray-700 mb-2">Nama Event</label>
                                <input type="text" name="nama_event" id="nama_event" value="{{ old('nama_event', $event->nama_event) }}" 
                                    class="w-full rounded-xl border-gray-200 focus:ring-blue-500 focus:border-blue-500 shadow-sm" required>
                                @error('nama_event') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="id_venue" class="block text-sm font-bold text-gray-700 mb-2">Lokasi / Venue</label>
                                <select name="id_venue" id="id_venue" class="w-full rounded-xl border-gray-200 focus:ring-blue-500 shadow-sm" required>
                                    @foreach($venues as $v)
                                        <option value="{{ $v->id_venue }}" {{ $event->id_venue == $v->id_venue ? 'selected' : '' }}>
                                            {{ $v->nama_venue }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="tanggal" class="block text-sm font-bold text-gray-700 mb-2">Tanggal Pelaksanaan</label>
                                <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $event->tanggal) }}" 
                                    class="w-full rounded-xl border-gray-200 focus:ring-blue-500 shadow-sm" required>
                            </div>

                            <div class="col-span-2">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Poster / Foto Event</label>
                                
                                @if($event->foto)
                                    <div class="mb-4">
                                        <p class="text-xs text-gray-500 mb-2 italic">Foto saat ini:</p>
                                        <img src="{{ asset('storage/events/' . $event->foto) }}" class="h-32 rounded-lg shadow-sm border">
                                    </div>
                                @endif

                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-2xl hover:border-blue-400 transition">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="foto" class="relative cursor-pointer bg-white rounded-md font-bold text-blue-600 hover:text-blue-500">
                                                <span>Ganti foto</span>
                                                <input id="foto" name="foto" type="file" class="sr-only" accept="image/*" onchange="previewImage(event)">
                                            </label>
                                            <p class="pl-1">atau abaikan jika tidak ingin diubah</p>
                                        </div>
                                    </div>
                                </div>
                                <img id="output" class="mt-4 rounded-xl hidden max-h-48 mx-auto shadow-md border-2 border-blue-500">
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.event.index') }}" class="text-sm font-bold text-gray-500 hover:text-gray-700 transition">
                                Batal
                            </a>
                            <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-200 transition transform active:scale-95">
                                Update Event
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