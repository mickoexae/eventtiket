<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Explore Events') }}
        </h2>
    </x-slot>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        .event-card {
            transition: transform 0.3s ease;
            border: none;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            background: #fff;
        }
        .event-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.12);
        }
        .card-img-top {
            height: 220px;
            object-fit: cover;
        }
        .status-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 2;
        }
        .badge-custom {
            font-size: 0.75rem;
            padding: 8px 15px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8">
                
                <h3 class="mb-5 text-center fw-bold text-gray-800">Daftar Event Seru</h3>

                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @forelse($events as $event)
                        <div class="col">
                            <div class="card event-card h-100 position-relative">
                                
                                @php
                                    // PERBAIKAN: Menggunakan 'stok' sesuai kolom di database kamu
                                    $totalStok = $event->tikets->sum('stok'); 
                                    
                                    $tanggalEvent = \Carbon\Carbon::parse($event->tanggal);
                                    $isExpired = $tanggalEvent->isPast() && !$tanggalEvent->isToday();
                                    $isToday = $tanggalEvent->isToday();
                                @endphp

                                <div class="status-badge">
                                    @if($isExpired)
                                        <span class="badge badge-custom bg-danger rounded-pill shadow-sm">Expired</span>
                                    @elseif($isToday)
                                        <span class="badge badge-custom bg-success rounded-pill shadow-sm">Hari Ini</span>
                                    @elseif($totalStok <= 0)
                                        <span class="badge badge-custom bg-secondary rounded-pill shadow-sm">Habis</span>
                                    @else
                                        <span class="badge badge-custom bg-primary rounded-pill shadow-sm">Tersedia</span>
                                    @endif
                                </div>

                                @if($event->foto)
                                    <img src="{{ asset('storage/' . $event->foto) }}" class="card-img-top" alt="{{ $event->nama_event }}">
                                @else
                                    <img src="{{ asset('images/default-event.jpg') }}" class="card-img-top" alt="Default Image">
                                @endif

                                <div class="card-body d-flex flex-column p-4">
                                    <h5 class="card-title fw-bold text-gray-900 mb-3">{{ $event->nama_event }}</h5>
                                    
                                    <div class="mb-2">
                                        <p class="card-text text-muted mb-1 small">
                                            <i class="bi bi-geo-alt-fill text-danger me-2"></i>
                                            <strong>Lokasi:</strong> {{ $event->venue->nama_venue ?? 'Lokasi tidak diatur' }}
                                        </p>
                                        <p class="card-text text-muted small">
                                            <i class="bi bi-calendar-event text-primary me-2"></i>
                                            <strong>Tanggal:</strong> {{ $tanggalEvent->translatedFormat('d F Y') }}
                                        </p>
                                    </div>

                                    <p class="text-xs text-gray-400 mt-2">Sisa Tiket: {{ $totalStok }}</p>

                                    <div class="mt-auto pt-4">
                                        @if($isExpired || $totalStok <= 0)
                                            <button class="btn btn-light disabled w-100 py-2 fw-bold text-gray-400" style="border-radius: 12px;">
                                                Tidak Tersedia
                                            </button>
                                        @else
                                            <a href="{{ route('user.event.detail', $event->id_event) }}" class="btn btn-primary w-100 py-2 fw-bold" style="border-radius: 12px; background: #2563eb; border: none;">
                                                Lihat Tiket
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-10">
                            <img src="{{ asset('images/empty-state.svg') }}" alt="Empty" class="mx-auto mb-4" style="width: 200px; opacity: 0.5;">
                            <p class="text-gray-500 fw-medium">Belum ada event yang tersedia saat ini.</p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>