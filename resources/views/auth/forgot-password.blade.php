<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-coffee mb-2">Lupa Kata Sandi?</h2>
        <p class="text-sm text-text-muted">Jangan khawatir. Masukkan email Anda dan kami akan mengirimkan tautan reset.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-xs font-semibold uppercase tracking-wider text-coffee" />
            <x-text-input id="email" class="block mt-1 w-full rounded-xl border-gray-200 focus:ring-gold focus:border-gold transition-all duration-300" type="email" name="email" :value="old('email')" required autofocus placeholder="email@contoh.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-4 text-sm tracking-widest shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                {{ __('KIRIM TAUTAN RESET') }}
            </x-primary-button>
        </div>

        <div class="text-center mt-6">
            <a href="{{ route('login') }}" class="text-sm font-bold text-coffee hover:text-gold transition-colors">
                Kembali ke Login
            </a>
        </div>
    </form>
</x-guest-layout>
