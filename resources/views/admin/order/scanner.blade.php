<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-2xl shadow-lg border-b-4 border-indigo-500">
                <h2 class="text-2xl font-black mb-6 text-gray-800 uppercase">Scanner Check-in</h2>

                {{-- Alert Notifikasi --}}
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 font-bold rounded-lg">
                        🎉 {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 font-bold rounded-lg">
                        ❌ {{ session('error') }}
                    </div>
                @endif

                {{-- 1. BAGIAN KAMERA (Scanner) --}}
                <div class="mb-8">
                    <label class="block text-sm font-black uppercase text-gray-400 mb-2 text-center">Scan via Kamera</label>
                    <div id="reader" class="overflow-hidden rounded-xl border-2 border-dashed border-gray-300 bg-gray-50"></div>
                </div>

                <div class="relative flex py-5 items-center">
                    <div class="flex-grow border-t border-gray-300"></div>
                    <span class="flex-shrink mx-4 text-gray-400 font-bold uppercase text-xs">Atau</span>
                    <div class="flex-grow border-t border-gray-300"></div>
                </div>

                {{-- 2. BAGIAN INPUT KETIK (Manual) --}}
                <form id="form-scan" action="{{ route('admin.scanner.prosess') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-black uppercase text-gray-500 mb-2">Input Kode Manual</label>
                        <input type="text" name="kode_tiket" id="kode_tiket" autofocus 
                               class="w-full p-4 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-0 text-xl font-mono uppercase" 
                               placeholder="KETIK KODE DI SINI...">
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-xl transition uppercase shadow-lg shadow-indigo-200">
                        Validasi Tiket
                    </button>
                </form>

                <p class="mt-6 text-[10px] text-gray-400 text-center uppercase tracking-widest font-bold">
                    Sistem Validasi Tiket v1.0
                </p>
            </div>
        </div>
    </div>

    {{-- Script HTML5-QRCode --}}
    <script src="https://unpkg.com/html5-qrcode"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function onScanSuccess(decodedText) {
        // Hentikan scanner sementara agar tidak scan berulang kali saat proses
        html5QrcodeScanner.clear();

        fetch("{{ route('admin.scanner.prosess') }}", {
            method: "POST",
            headers: { 
                "Content-Type": "application/json",
                "Accept": "application/json", // Penting agar Laravel tahu ini request AJAX
                "X-CSRF-TOKEN": "{{ csrf_token() }}" 
            },
            body: JSON.stringify({ kode_tiket: decodedText })
        })
        .then(response => {
            if (response.status === 419) {
                throw new Error("Sesi berakhir, silakan refresh halaman.");
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Check-in Berhasil!',
                    text: data.message,
                    timer: 3000
                }).then(() => {
                    // Mulai ulang scanner setelah user klik OK atau timer habis
                    location.reload(); 
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: data.message
                }).then(() => {
                    location.reload();
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'warning',
                title: 'Error Sistem',
                text: error.message
            }).then(() => {
                location.reload();
            });
        });
    }

    function onScanFailure(error) {
        // Biarkan kosong agar tidak mengganggu proses scanning
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", 
        { 
            fps: 10, 
            qrbox: { width: 250, height: 250 },
            aspectRatio: 1.0 
        }, 
        /* verbose= */ false
    );
    
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>
</x-app-layout>