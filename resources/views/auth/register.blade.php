<x-guest-layout>
    <div class="px-4 py-6">
        <!-- Brand / Logo Area -->
        <div class="flex justify-center mb-8">
            <div class="p-3 rounded-2xl bg-indigo-50">
                <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
        </div>

        <!-- Header Section -->
        <div class="text-center mb-10">
            <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">
                {{ __('Buat Akun Baru') }}
            </h2>
            <p class="mt-2 text-sm text-gray-500 font-medium">
                {{ __('Bergabunglah dengan kami dan mulai kelola proyek Anda.') }}
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Nama Lengkap -->
            <div class="group">
                <x-input-label for="nama" :value="__('Nama Lengkap')" class="block text-sm font-semibold text-gray-700 group-focus-within:text-indigo-600 transition-colors" />
                <div class="mt-2 relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400 group-focus-within:text-indigo-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <x-text-input id="nama" 
                        class="block w-full pl-11 pr-4 py-3.5 rounded-xl border-gray-200 bg-gray-50/30 focus:bg-white focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all duration-200 text-sm placeholder:text-gray-400 shadow-sm" 
                        type="text" 
                        name="nama" 
                        :value="old('nama')" 
                        required 
                        autofocus 
                        autocomplete="name" 
                        placeholder="John Doe" />
                </div>
                <x-input-error :messages="$errors->get('nama')" class="mt-2 text-xs font-medium" />
            </div>

            <!-- Email Address -->
            <div class="group">
                <x-input-label for="email" :value="__('Alamat Email')" class="block text-sm font-semibold text-gray-700 group-focus-within:text-indigo-600 transition-colors" />
                <div class="mt-2 relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400 group-focus-within:text-indigo-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                        </svg>
                    </div>
                    <x-text-input id="email" 
                        class="block w-full pl-11 pr-4 py-3.5 rounded-xl border-gray-200 bg-gray-50/30 focus:bg-white focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all duration-200 text-sm placeholder:text-gray-400 shadow-sm" 
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        required 
                        placeholder="nama@email.com" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs font-medium" />
            </div>

            <!-- Password -->
            <div class="group">
                <x-input-label for="password" :value="__('Kata Sandi')" class="block text-sm font-semibold text-gray-700 group-focus-within:text-indigo-600 transition-colors" />
                <div class="mt-2 relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400 group-focus-within:text-indigo-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <x-text-input id="password" 
                        class="block w-full pl-11 pr-4 py-3.5 rounded-xl border-gray-200 bg-gray-50/30 focus:bg-white focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all duration-200 text-sm placeholder:text-gray-400 shadow-sm"
                        type="password"
                        name="password"
                        required 
                        autocomplete="new-password" 
                        placeholder="Minimal 8 karakter" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs font-medium" />
            </div>

            <!-- Confirm Password -->
            <div class="group">
                <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" class="block text-sm font-semibold text-gray-700 group-focus-within:text-indigo-600 transition-colors" />
                <div class="mt-2 relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400 group-focus-within:text-indigo-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <x-text-input id="password_confirmation" 
                        class="block w-full pl-11 pr-4 py-3.5 rounded-xl border-gray-200 bg-gray-50/30 focus:bg-white focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all duration-200 text-sm placeholder:text-gray-400 shadow-sm"
                        type="password"
                        name="password_confirmation"
                        required 
                        placeholder="Ulangi kata sandi" />
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs font-medium" />
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <x-primary-button class="w-full flex justify-center items-center py-4 rounded-xl bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] text-white font-bold text-base shadow-lg shadow-indigo-100 transition-all duration-200">
                    {{ __('Daftar Sekarang') }}
                    <svg class="ms-2 w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3" />
                    </svg>
                </x-primary-button>
            </div>

            <!-- Login Redirect -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500 font-medium">
                    {{ __('Sudah memiliki akun?') }}
                    <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-500 transition-all">
                        {{ __('Masuk di sini') }}
                    </a>
                </p>
            </div>
        </form>

        <!-- Footer Info -->
        <div class="mt-12 pt-6 border-t border-gray-100 flex items-center justify-center space-x-2 text-[11px] font-bold uppercase tracking-widest text-gray-400">
            <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Informasi Anda Terlindungi</span>
        </div>
    </div>
</x-guest-layout>