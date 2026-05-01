<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold text-coffee mb-2">Bergabung Bersama Kami</h2>
        <p class="text-sm text-text-muted">Buat akun untuk pengalaman pemesanan yang lebih personal</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-xs font-semibold uppercase tracking-wider text-coffee" />
            <x-text-input id="name" class="block mt-1 w-full rounded-xl border-gray-200 focus:ring-gold focus:border-gold transition-all duration-300" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama Anda" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-xs font-semibold uppercase tracking-wider text-coffee" />
            <x-text-input id="email" class="block mt-1 w-full rounded-xl border-gray-200 focus:ring-gold focus:border-gold transition-all duration-300" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="email@contoh.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Kata Sandi')" class="text-xs font-semibold uppercase tracking-wider text-coffee" />
            <x-text-input id="password" class="block mt-1 w-full rounded-xl border-gray-200 focus:ring-gold focus:border-gold transition-all duration-300"
                            type="password"
                            name="password"
                            required autocomplete="new-password"
                            placeholder="Min. 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" class="text-xs font-semibold uppercase tracking-wider text-coffee" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-xl border-gray-200 focus:ring-gold focus:border-gold transition-all duration-300"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="Ulangi kata sandi" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-4">
            <x-primary-button class="w-full justify-center py-4 text-sm tracking-widest shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                {{ __('DAFTAR SEKARANG') }}
            </x-primary-button>
        </div>

        <div class="text-center pt-6 border-t border-gray-100 mt-6">
            <p class="text-sm text-text-muted">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-bold text-coffee hover:text-gold transition-colors">
                    Login di sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
