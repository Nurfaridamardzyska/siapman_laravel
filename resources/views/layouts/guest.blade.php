<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SIAPMAN') }} - Autentikasi</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                font-family: 'Outfit', sans-serif;
                background-color: #0f172a;
                background-image: 
                    radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), 
                    radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), 
                    radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%);
                background-attachment: fixed;
                background-size: cover;
                color: #e2e8f0;
            }
            .glass-card {
                background: rgba(255, 255, 255, 0.03);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                border: 1px solid rgba(255, 255, 255, 0.05);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            }
            .animate-fade-in-up {
                animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
                opacity: 0;
                transform: translateY(20px);
            }
            @keyframes fadeInUp {
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            .input-field {
                background: rgba(15, 23, 42, 0.6);
                border: 1px solid rgba(255, 255, 255, 0.1);
                color: white;
                transition: all 0.3s ease;
            }
            .input-field:focus {
                background: rgba(15, 23, 42, 0.8);
                border-color: #6366f1;
                box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.2);
            }
        </style>
    </head>
    <body class="antialiased min-h-screen flex items-center justify-center relative overflow-hidden">
        
        <!-- Decorative Background Orbs -->
        <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-indigo-600 rounded-full mix-blend-multiply filter blur-[128px] opacity-40 animate-pulse" style="animation-duration: 8s;"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-rose-600 rounded-full mix-blend-multiply filter blur-[128px] opacity-40 animate-pulse" style="animation-duration: 10s; animation-delay: 2s;"></div>

        <div class="w-full max-w-md px-6 py-12 relative z-10 animate-fade-in-up">
            
            <!-- Branding -->
            <div class="flex flex-col items-center justify-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-tr from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-500/30 mb-4 transform hover:scale-105 transition-transform duration-300">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.071 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path></svg>
                </div>
                <h1 class="text-3xl font-extrabold tracking-tight text-white">SIAPMAN</h1>
                <p class="text-slate-400 text-sm mt-1 font-medium">Sistem Informasi Absensi & Presensi Mandiri</p>
            </div>

            <!-- Card -->
            <div class="glass-card rounded-3xl p-8">
                {{ $slot }}
            </div>
            
            <p class="text-center text-slate-500 text-xs mt-8 font-medium">
                &copy; {{ date('Y') }} SIAPMAN. All rights reserved.
            </p>
        </div>
    </body>
</html>
