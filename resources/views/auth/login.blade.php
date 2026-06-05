<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-slate-300 mb-2">{{ __('Alamat Email') }}</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <input id="email" class="input-field block w-full pl-10 pr-3 py-3 rounded-xl sm:text-sm focus:outline-none" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Masukkan email Anda" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-400" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-slate-300 mb-2">{{ __('Kata Sandi') }}</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <input id="password" class="input-field block w-full pl-10 pr-3 py-3 rounded-xl sm:text-sm focus:outline-none" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-400" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mt-6">
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" class="h-4 w-4 rounded border-slate-600 bg-slate-800 text-indigo-500 focus:ring-indigo-500 focus:ring-offset-slate-900" name="remember">
                <label for="remember_me" class="ml-2 block text-sm text-slate-400">
                    {{ __('Ingat saya') }}
                </label>
            </div>

            @if (Route::has('password.request'))
                <div class="text-sm">
                    <a href="{{ route('password.request') }}" class="font-medium text-indigo-400 hover:text-indigo-300 transition-colors">
                        {{ __('Lupa sandi?') }}
                    </a>
                </div>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg shadow-indigo-500/30 text-sm font-bold text-white bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-400 hover:to-purple-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 focus:ring-offset-slate-900 transform hover:-translate-y-0.5 transition-all duration-200">
                {{ __('Masuk ke Dashboard') }}
            </button>
        </div>
    </form>
</x-guest-layout>
