<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-coffee mb-2">Reset Kata Sandi</h2>
        <p class="text-sm text-text-muted">Masukkan email dan kata sandi baru Anda.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-xs font-semibold uppercase tracking-wider text-coffee" />
            <x-text-input id="email" class="block mt-1 w-full rounded-xl border-gray-200 focus:ring-gold focus:border-gold transition-all duration-300" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Kata Sandi Baru')" class="text-xs font-semibold uppercase tracking-wider text-coffee" />
            <x-text-input id="password" class="block mt-1 w-full rounded-xl border-gray-200 focus:ring-gold focus:border-gold transition-all duration-300" type="password" name="password" required autocomplete="new-password" placeholder="Min. 8 karakter" />
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

        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-4 text-sm tracking-widest shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                {{ __('RESET KATA SANDI') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
