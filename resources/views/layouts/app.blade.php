<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ===== MODERN MINIMALIS STYLE (konsisten dengan landing page) ===== */
        :root {
            --warna-utama: #3b82f6;      /* Biru modern */
            --warna-sidebar: #ffffff;    /* Sidebar putih */
            --warna-bg-konten: #f9fafb;  /* Latar abu-abu sangat terang */
            --font-utama: 'Figtree', 'Inter', system-ui, sans-serif;
        }

        /* Global reset */
        body {
            font-family: var(--font-utama);
            background-color: var(--warna-bg-konten);
            margin: 0;
            padding: 0;
        }

        /* Scrollbar halus */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--warna-utama);
        }

        /* Animasi fade-in untuk konten */
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Typography tambahan */
        .page-header {
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: -0.02em;
            color: #1e293b;
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", timer: 2000, showConfirmButton: false });
    @endif
    @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Gagal!', text: "{{ session('error') }}" });
    @endif
</script>

<body class="antialiased">
    <div class="flex min-h-screen">
        {{-- SIDEBAR (modern minimalis putih) --}}
        @include('layouts.navigation')

        {{-- AREA KONTEN UTAMA --}}
        <div class="flex-1 flex flex-col min-w-0">
            {{-- TOPBAR minimalis --}}
            <header class="bg-white border-b border-gray-100 px-8 py-3 flex justify-end items-center shadow-sm">
                <div class="text-xs font-medium text-gray-500 tracking-wide">
                    {{ Auth::user()->nama }} 
                    <span class="text-gray-400 mx-1">|</span>
                    <span class="text-blue-500 font-semibold">{{ ucfirst(Auth::user()->role) }}</span>
                </div>
            </header>

            {{-- MAIN CONTENT --}}
            <main class="flex-1 p-8 overflow-y-auto">
                @isset($header)
                    <div class="page-header">
                        {{ $header }}
                    </div>
                @endisset

                <div class="animate-fade-in">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>
</html>