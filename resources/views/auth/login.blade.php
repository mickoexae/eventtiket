<x-guest-layout>
    <div class="px-4 py-6">
        <div class="flex justify-center mb-10">
            <div class="p-3 rounded-2xl bg-indigo-50">
                <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
        </div>

        <div class="text-center mb-10">
            <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">
                {{ __('Masuk ke Akun Anda') }}
            </h2>
            <p class="mt-2 text-sm text-gray-500 font-medium">
                {{ __('Gunakan kredensial terdaftar untuk melanjutkan.') }}
            </p>
        </div>

        <x-auth-session-status class="mb-6" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

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
                        autofocus 
                        placeholder="nama@email.com" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs font-medium" />
            </div>

            <div class="group">
                <div class="flex items-center justify-between">
                    <x-input-label for="password" :value="__('Kata Sandi')" class="block text-sm font-semibold text-gray-700 group-focus-within:text-indigo-600 transition-colors" />
                    @if (Route::has('password.request'))
                        <a class="text-xs font-bold text-indigo-600 hover:text-indigo-500 transition-all" href="{{ route('password.request') }}">
                            {{ __('Lupa kata sandi?') }}
                        </a>
                    @endif
                </div>
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
                        placeholder="••••••••" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs font-medium" />
            </div>

            <div class="flex items-center justify-between py-2">
                <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                    <input id="remember_me" type="checkbox" class="h-4 w-4 rounded-md border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 transition-all cursor-pointer" name="remember">
                    <span class="ms-3 text-sm font-medium text-gray-600 group-hover:text-gray-900 transition-colors">{{ __('Ingat saya') }}</span>
                </label>
            </div>

            <div class="pt-2">
                <x-primary-button class="w-full flex justify-center items-center py-4 rounded-xl bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] text-white font-bold text-base shadow-lg shadow-indigo-100 transition-all duration-200">
                    {{ __('Masuk Sekarang') }}
                    <svg class="ms-2 w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </x-primary-button>
            </div>

            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500 font-medium">
                    {{ __('Belum memiliki akun?') }}
                    <a href="{{ route('register') }}" class="font-bold text-indigo-600 hover:text-indigo-500 transition-all">
                        {{ __('Daftar di sini') }}
                    </a>
                </p>
            </div>
        </form>

        <div class="mt-12 pt-6 border-t border-gray-100 flex items-center justify-center space-x-2 text-[11px] font-bold uppercase tracking-widest text-gray-400">
            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M2.166 4.9L10 .3l7.834 4.6a1 1 0 01.5 1.175l-1.4 5.925a1 1 0 01-.19.41L12.33 19.1a1 1 0 01-1.66 0l-4.414-6.69a1 1 0 01-.19-.41l-1.4-5.925a1 1 0 01.5-1.175zM10 14.2l3.414-5.186a1 1 0 00-.09-1.29l-3.324-1.95v8.426z" clip-rule="evenodd" />
            </svg>
            <span>End-to-End Encryption</span>
        </div>
    </div>
</x-guest-layout>