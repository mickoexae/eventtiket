<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">Tambah Kategori Tiket</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- 1. ALERT PERINGATAN (SESSION ERROR) --}}
            @if(session('error'))
                <div class="mb-6 flex items-center p-4 text-sm text-red-800 border border-red-300 rounded-2xl bg-red-50" role="alert">
                    <svg class="flex-shrink-0 inline w-4 h-4 me-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <div>
                        <span class="font-bold uppercase tracking-tight">Peringatan:</span> {{ session('error') }}
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.tiket.store') }}" method="POST">
                @csrf
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    
                    {{-- 2. PILIH EVENT --}}
                    <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Event</label>
                        <select name="id_event" id="id_event" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-blue-500" required>
                            <option value="">-- Pilih Event --</option>
                            @foreach($events as $event)
                                <option value="{{ $event->id_event }}" data-kapasitas="{{ $event->venue->kapasitas }}">
                                    {{ $event->nama_event }} (Kapasitas: {{ $event->venue->kapasitas }})
                                </option>
                            @endforeach
                        </select>
                        <p id="info-kapasitas" class="mt-2 text-xs text-blue-600 font-bold uppercase tracking-widest hidden">
                            ✨ Kapasitas Tersedia: <span id="max-val">0</span>
                        </p>
                    </div>

                    <hr class="mb-8 border-gray-100">

                    {{-- 3. BAGIAN KATEGORI TIKET --}}
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-black uppercase text-gray-800 tracking-tight">Kategori Tiket</h3>
                        <button type="button" id="btn-tambah-tiket" class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-xs font-bold uppercase rounded-lg transition">
                            <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                            Tambah Kategori
                        </button>
                    </div>

                    <div id="container-tiket" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-5 bg-gray-50 rounded-2xl border border-gray-100 relative row-tiket">
                            <div>
                                <label class="block text-[10px] font-black uppercase text-gray-400 mb-1">Nama Tiket</label>
                                <input type="text" name="nama_tiket[]" class="w-full rounded-lg border-gray-200 text-sm focus:ring-blue-500" placeholder="Contoh: VIP" required>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase text-gray-400 mb-1">Harga (RP)</label>
                                {{-- TAMBAHKAN min="1" --}}
                                <input type="number" name="harga[]" min="1" class="w-full rounded-lg border-gray-200 text-sm focus:ring-blue-500" placeholder="150000" required>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase text-gray-400 mb-1">Stok/Kuota</label>
                                {{-- TAMBAHKAN min="1" --}}
                                <input type="number" name="stok[]" min="1" class="input-stok w-full rounded-lg border-gray-200 text-sm focus:ring-blue-500" placeholder="50" required>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12">
                        <button type="submit" id="btn-simpan" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-2xl shadow-xl shadow-blue-200 transition-all transform active:scale-95 uppercase tracking-widest">
                            Simpan Semua Kategori Tiket
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('btn-tambah-tiket').addEventListener('click', function() {
            const container = document.getElementById('container-tiket');
            const newRow = document.createElement('div');
            newRow.className = 'grid grid-cols-1 md:grid-cols-3 gap-4 p-5 bg-gray-50 rounded-2xl border border-gray-100 relative group animate-fade-in mt-4 row-tiket';
            
            newRow.innerHTML = `
                <div>
                    <input type="text" name="nama_tiket[]" class="w-full rounded-lg border-gray-200 text-sm focus:ring-blue-500" placeholder="Nama Tiket" required>
                </div>
                <div>
                    <input type="number" name="harga[]" min="1" class="w-full rounded-lg border-gray-200 text-sm focus:ring-blue-500" placeholder="Harga" required>
                </div>
                <div class="flex gap-2">
                    <input type="number" name="stok[]" min="1" class="input-stok w-full rounded-lg border-gray-200 text-sm focus:ring-blue-500" placeholder="Stok" required>
                    <button type="button" class="btn-hapus-tiket p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
            `;
            container.appendChild(newRow);
        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-hapus-tiket')) {
                const row = e.target.closest('.row-tiket');
                row.remove();
                cekKapasitas();
            }
        });

        const eventSelect = document.getElementById('id_event');
        const infoKapasitas = document.getElementById('info-kapasitas');
        const maxValSpan = document.getElementById('max-val');

        function cekKapasitas() {
            const selectedOption = eventSelect.options[eventSelect.selectedIndex];
            const kapasitas = parseInt(selectedOption.getAttribute('data-kapasitas')) || 0;
            
            if (kapasitas > 0) {
                infoKapasitas.classList.remove('hidden');
                maxValSpan.innerText = kapasitas;
            } else {
                infoKapasitas.classList.add('hidden');
            }

            const allInputStok = document.querySelectorAll('.input-stok');
            let totalInput = 0;
            allInputStok.forEach(input => {
                totalInput += parseInt(input.value) || 0;
            });

            if (totalInput > kapasitas && kapasitas > 0) {
                alert('⚠️ Peringatan: Total stok (' + totalInput + ') melebihi kapasitas venue (' + kapasitas + ')!');
                allInputStok.forEach(el => el.classList.add('border-red-500', 'bg-red-50'));
            } else {
                allInputStok.forEach(el => el.classList.remove('border-red-500', 'bg-red-50'));
            }
        }

        eventSelect.addEventListener('change', cekKapasitas);
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('input-stok')) {
                cekKapasitas();
            }
        });
    </script>
    {{-- Style tetap sama --}}
</x-app-layout>