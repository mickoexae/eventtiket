<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'VentPro') }} - Platform Tiket Event Modern</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --blue-50: #eff6ff;
            --blue-100: #dbeafe;
            --blue-500: #3b82f6;
            --blue-600: #2563eb;
            --blue-700: #1d4ed8;
            --blue-900: #1e3a8a;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            color: var(--gray-900);
            -webkit-font-smoothing: antialiased;
        }

        /* ─── SCROLLBAR ─── */
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #bfdbfe; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--blue-500); }

        /* ─── NAVBAR ─── */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(229,231,235,0.8);
        }
        .navbar-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem;
            height: 68px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .brand-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--blue-500), var(--blue-700));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(59,130,246,0.35);
        }
        .brand-name {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 1.25rem;
            color: var(--gray-900);
            letter-spacing: -0.5px;
        }
        .brand-name span { color: var(--blue-600); }

        .nav-links { display: flex; align-items: center; gap: 8px; }
        .nav-link-ghost {
            padding: 8px 18px;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-700);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.15s ease;
        }
        .nav-link-ghost:hover { color: var(--blue-600); background: var(--blue-50); }
        .nav-link-primary {
            padding: 8px 20px;
            font-size: 0.875rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            background: linear-gradient(135deg, var(--blue-500), var(--blue-700));
            border-radius: 9px;
            box-shadow: 0 2px 8px rgba(59,130,246,0.4);
            transition: all 0.15s ease;
        }
        .nav-link-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(59,130,246,0.5);
        }

        /* ─── HERO ─── */
        .hero-section {
            max-width: 1280px;
            margin: 0 auto;
            padding: 5rem 2rem 4rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }
        @media (max-width: 900px) {
            .hero-section { grid-template-columns: 1fr; gap: 3rem; text-align: center; padding: 3rem 1.25rem; }
            .hero-cta { justify-content: center !important; }
            .hero-visual { order: -1; }
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--blue-50);
            border: 1px solid var(--blue-100);
            border-radius: 100px;
            padding: 6px 14px;
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--blue-600);
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
        }
        .hero-eyebrow-dot {
            width: 6px;
            height: 6px;
            background: var(--blue-500);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.3); }
        }

        .hero-title {
            font-family: 'DM Serif Display', Georgia, serif;
            font-size: clamp(2.6rem, 5vw, 3.8rem);
            font-weight: 400;
            line-height: 1.1;
            color: var(--gray-900);
            letter-spacing: -1px;
            margin: 0 0 1.25rem;
        }
        .hero-title-accent {
            color: var(--blue-600);
            font-style: italic;
        }
        .hero-desc {
            font-size: 1.05rem;
            color: var(--gray-500);
            line-height: 1.75;
            max-width: 480px;
            margin: 0 0 2rem;
        }
        @media (max-width: 900px) { .hero-desc { margin-left: auto; margin-right: auto; } }

        .hero-cta {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 13px 26px;
            background: linear-gradient(135deg, var(--blue-500), var(--blue-700));
            color: white;
            font-weight: 700;
            font-size: 0.9rem;
            border-radius: 11px;
            text-decoration: none;
            box-shadow: 0 4px 20px rgba(59,130,246,0.45);
            transition: all 0.2s ease;
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 24px rgba(59,130,246,0.5); }
        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 13px 26px;
            background: white;
            color: var(--gray-800);
            font-weight: 700;
            font-size: 0.9rem;
            border-radius: 11px;
            text-decoration: none;
            border: 1.5px solid var(--gray-200);
            transition: all 0.2s ease;
        }
        .btn-secondary:hover { border-color: var(--blue-300); background: var(--blue-50); color: var(--blue-700); }

        .hero-trust {
            margin-top: 2rem;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.82rem;
            color: var(--gray-400);
            font-weight: 500;
        }
        .trust-avatars {
            display: flex;
        }
        .trust-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 2px solid white;
            margin-right: -8px;
            font-size: 11px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        @media (max-width: 900px) { .hero-trust { justify-content: center; } }

        /* ─── HERO VISUAL ─── */
        .hero-visual { position: relative; }
        .stat-card-main {
            background: white;
            border-radius: 20px;
            border: 1px solid var(--gray-100);
            box-shadow: 0 20px 60px rgba(0,0,0,0.08), 0 4px 16px rgba(0,0,0,0.04);
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }
        .stat-card-main::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--blue-500), var(--blue-700));
        }
        .stat-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1px;
            background: var(--gray-100);
            border-radius: 12px;
            overflow: hidden;
        }
        .stat-item {
            background: white;
            padding: 1.5rem;
            text-align: center;
        }
        .stat-item:first-child { border-radius: 12px 0 0 0; }
        .stat-item:nth-child(2) { border-radius: 0 12px 0 0; }
        .stat-item:nth-child(3) { border-radius: 0 0 0 12px; }
        .stat-item:last-child { border-radius: 0 0 12px 0; }
        .stat-number {
            font-family: 'DM Serif Display', serif;
            font-size: 2.4rem;
            font-weight: 400;
            color: var(--blue-600);
            line-height: 1;
        }
        .stat-label {
            font-size: 0.78rem;
            color: var(--gray-400);
            font-weight: 600;
            margin-top: 6px;
            letter-spacing: 0.3px;
        }

        .floating-badge {
            position: absolute;
            background: white;
            border-radius: 12px;
            padding: 10px 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            font-weight: 700;
            animation: float 3s ease-in-out infinite;
            border: 1px solid var(--gray-100);
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }
        .badge-1 { top: -20px; right: -10px; color: #16a34a; animation-delay: 0s; }
        .badge-2 { bottom: -20px; left: -10px; color: var(--blue-600); animation-delay: 1.5s; }
        .badge-icon { font-size: 1.1rem; }

        /* ─── SECTION HEADER ─── */
        .section-eyebrow {
            display: inline-block;
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--blue-600);
            margin-bottom: 0.75rem;
        }
        .section-title {
            font-family: 'DM Serif Display', serif;
            font-size: clamp(1.8rem, 3.5vw, 2.6rem);
            font-weight: 400;
            color: var(--gray-900);
            margin: 0 0 0.75rem;
            letter-spacing: -0.5px;
            line-height: 1.15;
        }
        .section-desc {
            color: var(--gray-500);
            font-size: 1rem;
            line-height: 1.7;
            max-width: 520px;
        }

        /* ─── EVENTS SECTION ─── */
        .events-section {
            background: linear-gradient(180deg, #f8faff 0%, #fff 100%);
            padding: 5rem 0;
        }
        .section-container { max-width: 1280px; margin: 0 auto; padding: 0 2rem; }
        .section-header-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 3rem;
        }
        @media (max-width: 640px) {
            .section-header-row { flex-direction: column; align-items: flex-start; gap: 1rem; }
        }
        .see-all-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--blue-600);
            text-decoration: none;
            padding: 9px 18px;
            border: 1.5px solid var(--blue-200);
            border-radius: 9px;
            background: var(--blue-50);
            transition: all 0.15s;
        }
        .see-all-link:hover { background: var(--blue-600); color: white; border-color: transparent; }

        /* Event Cards */
        .events-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }
        @media (max-width: 1024px) { .events-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 640px) { .events-grid { grid-template-columns: 1fr; } }

        .event-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid var(--gray-100);
            box-shadow: 0 2px 12px rgba(0,0,0,0.04);
            transition: all 0.25s ease;
            display: flex;
            flex-direction: column;
        }
        .event-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 48px rgba(0,0,0,0.1);
            border-color: var(--blue-100);
        }
        .event-img-wrap {
            position: relative;
            height: 210px;
            overflow: hidden;
        }
        .event-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .event-card:hover .event-img-wrap img { transform: scale(1.05); }
        .event-badge {
            position: absolute;
            top: 14px;
            left: 14px;
            background: rgba(37,99,235,0.9);
            backdrop-filter: blur(8px);
            color: white;
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            padding: 5px 12px;
            border-radius: 100px;
        }
        .event-body {
            padding: 1.25rem 1.5rem 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .event-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0 0 0.5rem;
            line-height: 1.4;
            transition: color 0.15s;
        }
        .event-card:hover .event-title { color: var(--blue-600); }
        .event-desc {
            font-size: 0.855rem;
            color: var(--gray-500);
            line-height: 1.6;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex: 1;
            margin: 0 0 1.25rem;
        }
        .event-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 1rem;
            border-top: 1px solid var(--gray-100);
        }
        .event-price-label {
            font-size: 0.7rem;
            color: var(--gray-400);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .event-price {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--blue-600);
            font-family: 'DM Serif Display', serif;
        }
        .btn-buy {
            padding: 9px 20px;
            background: var(--gray-900);
            color: white;
            font-size: 0.82rem;
            font-weight: 700;
            border-radius: 9px;
            text-decoration: none;
            transition: all 0.15s;
            letter-spacing: 0.2px;
        }
        .btn-buy:hover { background: var(--blue-600); transform: translateY(-1px); }

        .events-empty {
            grid-column: 1/-1;
            text-align: center;
            padding: 5rem 2rem;
            background: white;
            border-radius: 16px;
            border: 2px dashed var(--gray-200);
        }
        .events-empty p { color: var(--gray-400); font-size: 1rem; font-style: italic; }

        /* ─── FEATURES SECTION ─── */
        .features-section {
            padding: 5rem 0;
            background: white;
        }
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-top: 3rem;
        }
        @media (max-width: 768px) { .features-grid { grid-template-columns: 1fr; } }

        .feature-card {
            padding: 2rem;
            border-radius: 16px;
            border: 1px solid var(--gray-100);
            background: var(--gray-50);
            position: relative;
            overflow: hidden;
            transition: all 0.25s ease;
        }
        .feature-card::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--blue-500), var(--blue-700));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }
        .feature-card:hover { border-color: var(--blue-100); box-shadow: 0 8px 30px rgba(59,130,246,0.08); }
        .feature-card:hover::after { transform: scaleX(1); }
        .feature-icon {
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, var(--blue-50), var(--blue-100));
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
            border: 1px solid var(--blue-100);
        }
        .feature-icon svg { width: 24px; height: 24px; color: var(--blue-600); }
        .feature-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0 0 0.6rem;
        }
        .feature-desc {
            font-size: 0.875rem;
            color: var(--gray-500);
            line-height: 1.7;
            margin: 0;
        }

        /* ─── DIVIDER ─── */
        .divider { border: none; border-top: 1px solid var(--gray-100); }

        /* ─── FOOTER ─── */
        .footer {
            background: var(--gray-900);
            color: var(--gray-400);
            padding: 2rem;
            text-align: center;
        }
        .footer-inner {
            max-width: 1280px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .footer-brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .footer-brand-icon {
            width: 30px;
            height: 30px;
            background: linear-gradient(135deg, var(--blue-500), var(--blue-700));
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .footer-brand-name {
            font-weight: 700;
            font-size: 0.95rem;
            color: white;
        }
        .footer-brand-name span { color: var(--blue-400); }
        .footer-copy {
            font-size: 0.8rem;
            color: var(--gray-500);
        }

        /* ─── PAGE ANIMATION ─── */
        .fade-up {
            opacity: 0;
            transform: translateY(24px);
            animation: fadeUp 0.6s ease forwards;
        }
        .fade-up-d1 { animation-delay: 0.1s; }
        .fade-up-d2 { animation-delay: 0.2s; }
        .fade-up-d3 { animation-delay: 0.3s; }
        .fade-up-d4 { animation-delay: 0.4s; }
        @keyframes fadeUp {
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="antialiased">

    {{-- ═══════════════════════════ NAVBAR ═══════════════════════════ --}}
    <header class="navbar">
        <div class="navbar-inner">
            <a href="{{ url('/') }}" class="brand">
                <div class="brand-icon">
                    <x-application-logo class="w-5 h-5 fill-current text-white" />
                </div>
                <span class="brand-name">Vent<span>Pro</span></span>
            </a>

            <nav class="nav-links">
                @auth
                    <a href="{{ url('/dashboard') }}" class="nav-link-ghost">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="nav-link-ghost">Masuk</a>
                    <a href="{{ route('register') }}" class="nav-link-primary">Daftar Gratis</a>
                @endauth
            </nav>
        </div>
    </header>

    <main>
        {{-- ═══════════════════════════ HERO ═══════════════════════════ --}}
        <section style="background: linear-gradient(160deg, #f0f7ff 0%, #ffffff 55%); padding-top: 0;">
            <div class="hero-section">
                {{-- Left --}}
                <div>
                    <div class="hero-eyebrow fade-up fade-up-d1">
                        <span class="hero-eyebrow-dot"></span>
                        Platform Manajemen Event #1
                    </div>
                    <h1 class="hero-title fade-up fade-up-d2">
                        Kelola Tiket &amp; Event<br>
                        dengan <span class="hero-title-accent">Presisi Penuh</span>
                    </h1>
                    <p class="hero-desc fade-up fade-up-d3">
                        VentPro menghadirkan solusi end-to-end untuk penyelenggara event — dari penjualan tiket, scan QR, hingga laporan kehadiran real-time dalam satu dasbor terpadu.
                    </p>
                    <div class="hero-cta fade-up fade-up-d3">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-primary">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                Dashboard Saya
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn-primary">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                Mulai Sekarang
                            </a>
                            <a href="#events" class="btn-secondary">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                Jelajahi Event
                            </a>
                        @endauth
                    </div>
                    <div class="hero-trust fade-up fade-up-d4">
                        <div class="trust-avatars">
                            <div class="trust-avatar" style="background:#3b82f6;">A</div>
                            <div class="trust-avatar" style="background:#06b6d4;">B</div>
                            <div class="trust-avatar" style="background:#8b5cf6;">C</div>
                            <div class="trust-avatar" style="background:#f59e0b;">D</div>
                        </div>
                        <span style="margin-left: 14px;">50,000+ tiket telah terjual di platform ini</span>
                    </div>
                </div>

                {{-- Right: Stats --}}
                <div class="hero-visual fade-up fade-up-d2">
                    <div class="floating-badge badge-1">
                        <span class="badge-icon">✅</span>
                        Scan Tiket Berhasil
                    </div>
                    <div class="stat-card-main">
                        <p style="font-size: 0.72rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: var(--gray-400); margin: 0 0 1.25rem;">Statistik Platform</p>
                        <div class="stat-grid">
                            <div class="stat-item">
                                <div class="stat-number">500+</div>
                                <div class="stat-label">Event Aktif</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">50k+</div>
                                <div class="stat-label">Tiket Terjual</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">98%</div>
                                <div class="stat-label">Kepuasan</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">24/7</div>
                                <div class="stat-label">Dukungan</div>
                            </div>
                        </div>
                    </div>
                    <div class="floating-badge badge-2">
                        <span class="badge-icon">📊</span>
                        Laporan Real-time
                    </div>
                </div>
            </div>
        </section>

        {{-- ═══════════════════════════ EVENTS ═══════════════════════════ --}}
        <section id="events" class="events-section">
            <div class="section-container">
                <div class="section-header-row">
                    <div>
                        <span class="section-eyebrow">Event Pilihan</span>
                        <h2 class="section-title">Temukan Event<br>Terbaik Minggu Ini</h2>
                        <p class="section-desc" style="margin: 0;">Event-event pilihan yang siap memukau dan tak boleh kamu lewatkan.</p>
                    </div>
                    <a href="#" class="see-all-link">
                        Lihat Semua
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <div class="events-grid">
                    @forelse($events as $event)
                        <div class="event-card">
                            <div class="event-img-wrap">
                                <img src="{{ $event->foto ? asset('storage/'.$event->foto) : 'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?auto=format&fit=crop&w=800' }}"
                                     alt="{{ $event->nama_event }}">
                                <span class="event-badge">Terbaru</span>
                            </div>
                            <div class="event-body">
                                <h3 class="event-title">{{ $event->nama_event }}</h3>
                                <p class="event-desc">{{ $event->deskripsi ?? 'Nikmati pengalaman tak terlupakan di event spektakuler ini.' }}</p>
                                <div class="event-footer">
                                    <div>
                                        <p class="event-price-label">Mulai Dari</p>
                                        <p class="event-price">
                                            {{ $event->tikets_min_harga ? 'Rp ' . number_format($event->tikets_min_harga, 0, ',', '.') : 'Harga N/A' }}
                                        </p>
                                    </div>
                                    <a href="{{ route('login') }}" class="btn-buy">Beli Tiket</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="events-empty">
                            <p>Belum ada event yang tersedia saat ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        {{-- ═══════════════════════════ FEATURES ═══════════════════════════ --}}
        <section id="fitur" class="features-section">
            <div class="section-container">
                <div style="max-width: 520px;">
                    <span class="section-eyebrow">Fitur Unggulan</span>
                    <h2 class="section-title">Semua yang Kamu<br>Butuhkan, Satu Platform</h2>
                    <p class="section-desc">Solusi lengkap untuk penyelenggara event modern — dari validasi tiket hingga analitik mendalam.</p>
                </div>
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                        </div>
                        <h3 class="feature-title">Scan Tiket Instan</h3>
                        <p class="feature-desc">Validasi tiket masuk dengan scan QR code yang akurat dan anti-pemalsuan — proses ratusan tamu per menit tanpa hambatan.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </div>
                        <h3 class="feature-title">Analitik Real-time</h3>
                        <p class="feature-desc">Pantau kehadiran, pendapatan, dan performa event secara langsung dari dasbor terpadu yang intuitif dan informatif.</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <h3 class="feature-title">Manajemen Multi-Role</h3>
                        <p class="feature-desc">Akses bertingkat untuk admin, petugas, dan pengguna biasa — kontrol penuh atas siapa yang bisa melakukan apa dalam sistemmu.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    {{-- ═══════════════════════════ FOOTER ═══════════════════════════ --}}
    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-brand">
                <div class="footer-brand-icon">
                    <x-application-logo class="w-4 h-4 fill-current text-white" />
                </div>
                <span class="footer-brand-name">Vent<span>Pro</span></span>
            </div>
            <p class="footer-copy">&copy; {{ date('Y') }} VentPro. All rights reserved. Built with Laravel &amp; Tailwind CSS.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", timer: 2000, showConfirmButton: false });
        @endif
    </script>
</body>
</html>