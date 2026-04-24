<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Scan Tiket Masuk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl p-6">
                
                <div class="mb-6">
                    <div id="reader" class="overflow-hidden rounded-xl border-2 border-dashed border-gray-300"></div>
                </div>

                <hr class="my-6">
                <div class="max-w-md mx-auto sm:px-6 lg:px-8 mb-4">
    <div class="grid grid-cols-2 gap-4">
        <div class="bg-green-100 p-4 rounded-2xl border border-green-200">
            <p class="text-xs text-green-600 font-bold uppercase">Sudah Masuk</p>
            <p class="text-2xl font-black text-green-800">{{ $sudahHadir }}</p>
        </div>
        <div class="bg-orange-100 p-4 rounded-2xl border border-orange-200">
            <p class="text-xs text-orange-600 font-bold uppercase">Belum Hadir</p>
            <p class="text-2xl font-black text-orange-800">{{ $belumHadir }}</p>
        </div>
    </div>
</div>

                <form action="{{ route('admin.scanner.prosess') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="kode_tiket" class="block text-sm font-medium text-gray-700 mb-2">Atau Masukkan Kode Tiket Manual</label>
                        <input type="text" name="kode_tiket" id="kode_tiket" 
                               class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm font-mono uppercase" 
                               placeholder="Contoh: TIX-12345" required>
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg transition text-sm">
                        CHECK-IN TIKET
                    </button>
                </form>

            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            // Masukkan hasil scan ke input
            const inputField = document.getElementById('kode_tiket');
            inputField.value = decodedText;
            
            // Matikan scanner dulu biar gak ngirim data berkali-kali (bounce)
            html5QrcodeScanner.clear().then(_ => {
                // Submit form otomatis
                document.querySelector('form').submit();
            }).catch(error => {
                console.warn("Gagal menghentikan scanner:", error);
                document.querySelector('form').submit();
            });
        }

        function onScanFailure(error) {
            // Biarkan kosong agar tidak spam log
        }

        // Konfigurasi agar kamera yang digunakan adalah kamera belakang (environment)
        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", 
            { 
                fps: 10, 
                qrbox: {width: 250, height: 250},
                // Menambahkan aspek rasio agar tampilan di HP lebih pas
                aspectRatio: 1.0 
            }, 
            /* verbose= */ false
        );
        
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    </script>
</x-app-layout>