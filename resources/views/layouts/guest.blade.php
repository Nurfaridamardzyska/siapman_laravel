<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SIAPMAN') }} - Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                font-family: 'Inter', sans-serif;
                background-color: #f8fafc;
            }
            .corporate-bg {
                background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            }
            .glass-card {
                background: #ffffff;
                border: 1px solid rgba(226, 232, 240, 0.8);
                box-shadow: 0 10px 40px -10px rgba(15, 23, 42, 0.08);
            }
            .animate-fade-in-up {
                animation: fadeInUp 0.6s ease-out forwards;
                opacity: 0;
                transform: translateY(15px);
            }
            @keyframes fadeInUp {
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            .input-field {
                background: #ffffff;
                border: 1px solid #cbd5e1;
                color: #334155;
                transition: all 0.2s ease;
            }
            .input-field:focus {
                border-color: #2563eb;
                box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
            }
        </style>
    </head>
    <body class="antialiased min-h-screen flex items-center justify-center relative overflow-hidden corporate-bg">
        
        <!-- Decorative Background Shapes -->
        <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-blue-900 to-blue-800" style="clip-path: polygon(0 0, 100% 0, 100% 60%, 0% 100%);"></div>

        <div class="w-full max-w-[420px] px-6 py-12 relative z-10 animate-fade-in-up">
            
            <!-- Branding -->
            <div class="flex flex-col items-center justify-center mb-8">
                <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center shadow-md mb-4 border border-slate-100">
                    <svg class="w-9 h-9 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <h1 class="text-3xl font-extrabold tracking-tight text-white">SIAPMAN</h1>
                <p class="text-blue-100 text-sm mt-1 font-medium">Sistem Informasi Absensi & Presensi Mandiri</p>
            </div>

            <!-- Card -->
            <div class="glass-card rounded-2xl p-8">
                {{ $slot }}
            </div>
            
            <p class="text-center text-slate-500 text-xs mt-8 font-medium">
                &copy; {{ date('Y') }} SIAPMAN. All rights reserved.
            </p>
        </div>
    </body>
</html>
