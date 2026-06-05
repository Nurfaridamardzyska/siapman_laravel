<x-guest-layout>
    <div class="mb-6 text-sm text-slate-600 leading-relaxed text-center">
        {{ __('Lupa kata sandi? Tidak masalah. Masukkan alamat email Anda di bawah ini dan kami akan mengirimkan tautan untuk mereset kata sandi Anda.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">{{ __('Alamat Email') }}</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <input id="email" class="input-field block w-full pl-10 pr-3 py-2.5 rounded-lg text-sm focus:outline-none" type="email" name="email" :value="old('email')" required autofocus placeholder="Masukkan email Anda" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-500" />
        </div>

        <div class="pt-4 flex flex-col space-y-3">
            <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 transform hover:-translate-y-0.5 transition-all duration-200">
                {{ __('Kirim Tautan Reset Sandi') }}
            </button>
            <a href="{{ route('login') }}" class="w-full flex justify-center py-2.5 px-4 border border-slate-300 rounded-lg shadow-sm text-sm font-bold text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600 transition-all duration-200">
                {{ __('Kembali ke Login') }}
            </a>
        </div>
    </form>
</x-guest-layout>
