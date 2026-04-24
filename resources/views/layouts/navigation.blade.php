<nav class="w-72 bg-white min-h-screen flex flex-col shadow-sm border-r border-gray-100 sticky top-0 z-30">
    {{-- LOGO AREA --}}
    <div class="p-6">
        <div class="flex items-center gap-3">
            <div class="bg-blue-500 p-1.5 rounded-lg">
                <x-application-logo class="w-7 h-7 fill-current text-white" />
            </div>
            <h1 class="text-gray-800 font-bold text-xl tracking-tight uppercase italic">
                Vent<span class="text-blue-500">Pro</span>
            </h1>
        </div>
    </div>

    {{-- MENU UTAMA --}}
    <div class="flex-1 px-4 overflow-y-auto custom-scrollbar">
        <div class="space-y-7">
            
            {{-- DASHBOARD --}}
            <div>
                <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider px-3 mb-2">Main Menu</p>
                <div class="flex flex-col space-y-1">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="sidebar-item">
                        Dashboard
                    </x-nav-link>
                </div>
            </div>

            {{-- OPERASIONAL (ADMIN & PETUGAS) --}}
            @if(Auth::user()->role == 'admin' || Auth::user()->role == 'petugas')
                <div>
                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider px-3 mb-2">Operasional</p>
                    <div class="flex flex-col space-y-1">
                        <x-nav-link :href="route('admin.scanner')" :active="request()->routeIs('admin.scanner')" class="sidebar-item">
                            Scan Tiket
                        </x-nav-link>
                        <x-nav-link :href="route('admin.laporan.kehadiran')" :active="request()->routeIs('admin.laporan.kehadiran')" class="sidebar-item">
                            Laporan Hadir
                        </x-nav-link>
                    </div>
                </div>
            @endif

            {{-- MASTER DATA (ADMIN ONLY) --}}
            @if(Auth::user()->role == 'admin')
                <div>
                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider px-3 mb-2">Master Data</p>
                    <div class="flex flex-col space-y-1">
                        <x-nav-link :href="route('admin.venue.index')" :active="request()->routeIs('admin.venue.*')" class="sidebar-item">Venue</x-nav-link>
                        <x-nav-link :href="route('admin.event.index')" :active="request()->routeIs('admin.event.*')" class="sidebar-item">Event</x-nav-link>
                        <x-nav-link :href="route('admin.tiket.index')" :active="request()->routeIs('admin.tiket.*')" class="sidebar-item">Tiket</x-nav-link>
                        <x-nav-link :href="route('admin.voucher.index')" :active="request()->routeIs('admin.voucher.*')" class="sidebar-item">Voucher</x-nav-link>
                        <x-nav-link :href="route('admin.order.index')" :active="request()->routeIs('admin.order.*')" class="sidebar-item">Order</x-nav-link>
                        <x-nav-link :href="route('admin.petugas.index')" :active="request()->routeIs('admin.petugas.*')" class="sidebar-item">Petugas</x-nav-link>
                        <x-nav-link :href="route('admin.user.index')" :active="request()->routeIs('admin.user.*')" class="sidebar-item">User Manager</x-nav-link>
                    </div>
                </div>
            @endif

            {{-- USER BIASA --}}
            @if(Auth::user()->role == 'user')
                <div>
                    <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider px-3 mb-2">E-Ticket</p>
                    <div class="flex flex-col space-y-1">
                        <x-nav-link :href="route('user.cari_tiket')" :active="request()->routeIs('user.cari_tiket')" class="sidebar-item">Cari Event</x-nav-link>
                        <x-nav-link :href="route('user.tiket_saya')" :active="request()->routeIs('user.tiket_saya')" class="sidebar-item">Tiket Saya</x-nav-link>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- PROFIL & LOGOUT --}}
    <div class="p-4 border-t border-gray-100">
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" 
                class="w-full flex items-center gap-3 p-2 rounded-xl hover:bg-gray-50 transition-all group text-left">
                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center font-bold text-blue-700 shrink-0">
                    {{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}
                </div>
                <div class="flex-1 overflow-hidden">
                    <p class="text-sm font-semibold text-gray-700 truncate">{{ Auth::user()->nama }}</p>
                    <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">{{ Auth::user()->role }}</p>
                </div>
                <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                </svg>
            </button>

            <div x-show="open" 
                @click.away="open = false"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95 -translate-y-2"
                x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                class="absolute bottom-full left-0 w-full mb-2 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-50">
                
                <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-xs font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                    ⚙️ Edit Profil
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                        class="w-full text-left px-4 py-3 text-xs font-medium text-red-500 hover:bg-red-50 transition-colors border-t border-gray-100">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<style>
    /* Style minimalis untuk menu item */
    .sidebar-item {
        display: flex !important;
        align-items: center !important;
        width: 100% !important;
        padding: 0.625rem 1rem !important;
        font-size: 0.875rem !important;
        font-weight: 500 !important;
        color: #4b5563 !important; /* gray-600 */
        border-radius: 0.5rem !important;
        transition: all 0.2s ease !important;
    }

    .sidebar-item:hover {
        background-color: #f9fafb !important; /* gray-50 */
        color: #111827 !important; /* gray-900 */
    }

    /* Menu aktif dengan sentuhan aksen biru */
    .sidebar-item[active="true"] {
        background-color: #eff6ff !important; /* blue-50 */
        color: #2563eb !important; /* blue-600 */
        font-weight: 600 !important;
    }

    /* Scrollbar minimalis */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e5e7eb;
        border-radius: 20px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #d1d5db;
    }
</style>