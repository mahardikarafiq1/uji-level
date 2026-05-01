<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold text-coffee mb-2">Selamat Datang</h2>
        <p class="text-sm text-text-muted">Masuk untuk melanjutkan pesanan Anda</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-xs font-semibold uppercase tracking-wider text-coffee" />
            <x-text-input id="email" class="block mt-1 w-full rounded-xl border-gray-200 focus:ring-gold focus:border-gold transition-all duration-300" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="email@contoh.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center">
                <x-input-label for="password" :value="__('Password')" class="text-xs font-semibold uppercase tracking-wider text-coffee" />
                @if (Route::has('password.request'))
                    <a class="text-xs text-gold hover:text-coffee-medium transition-colors" href="{{ route('password.request') }}">
                        Lupa sandi?
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="block mt-1 w-full rounded-xl border-gray-200 focus:ring-gold focus:border-gold transition-all duration-300"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="rounded-md border-gray-300 text-gold shadow-sm focus:ring-gold focus:ring-opacity-50" name="remember">
            <span class="ms-2 text-sm text-text-muted">{{ __('Ingat saya') }}</span>
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-4 text-sm tracking-widest shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                {{ __('MASUK SEKARANG') }}
            </x-primary-button>
        </div>

        <div class="text-center pt-6 border-t border-gray-100 mt-6">
            <p class="text-sm text-text-muted">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-bold text-coffee hover:text-gold transition-colors">
                    Daftar di sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
