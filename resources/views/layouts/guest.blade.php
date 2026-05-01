<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Login - {{ config('app.name', 'Felize Cafe') }}</title>

        <!-- Fonts from Cafe Theme -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,800;1,400&family=Inter:wght@300;400;500;600;700&family=Great+Vibes&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            :root {
                --coffee-darkest: #1a0d04; --coffee: #4b2a12; --coffee-medium: #6b3b1a; 
                --cream-lightest: #f0ebe3; --paper: #faf8f5; --gold: #c9a96e;
                --text-dark: #2b1608; --text-muted: #7a5e44;
            }
            body { font-family: 'Inter', sans-serif; color: var(--text-dark); background-color: var(--paper); }
            h1, h2, h3, h4, h5, h6, .font-serif { font-family: 'Playfair Display', serif; }
            .bg-paper { background-color: var(--paper); }
            .text-coffee { color: var(--coffee); }
            .bg-coffee { background-color: var(--coffee); }
            .bg-gold { background-color: var(--gold); }
            .border-gold { border-color: var(--gold); }
            .brand-font { font-family: 'Great Vibes', cursive; }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
            <!-- Background Image with Overlay -->
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/auth-bg.png') }}" alt="Background" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-60 backdrop-blur-[2px]"></div>
            </div>

            <!-- Back to Home -->
            <a href="/" class="absolute top-8 left-8 z-20 flex items-center text-white text-opacity-80 hover:text-white transition-all duration-300 group">
                <span class="mr-2 transform group-hover:-translate-x-1 transition-transform">←</span>
                <span class="text-sm font-medium uppercase tracking-wider">Kembali ke Beranda</span>
            </a>

            <div class="relative z-10 w-full max-w-md">
                <!-- Brand Logo -->
                <div class="text-center mb-10 transform transition-all duration-700 hover:scale-105">
                    <a href="/" class="brand-font text-6xl text-white drop-shadow-lg" style="text-decoration: none;">
                        felize cafe
                    </a>
                </div>

                <!-- Auth Card -->
                <div class="bg-white bg-opacity-95 backdrop-blur-xl shadow-2xl rounded-3xl overflow-hidden border border-white border-opacity-20 animate-fade-in-up">
                    <div class="px-8 pt-10 pb-12">
                        {{ $slot }}
                    </div>
                </div>
                
                <!-- Footer Info -->
                <p class="mt-8 text-center text-white text-opacity-60 text-xs tracking-widest uppercase">
                    &copy; {{ date('Y') }} Felize Cafe &bull; Premium Experience
                </p>
            </div>
        </div>

        <style>
            @keyframes fade-in-up {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-fade-in-up { animation: fade-in-up 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
            
            /* Custom Form Styles for Premium Feel */
            input:focus { border-color: var(--gold) !important; ring-color: var(--gold) !important; }
            .brand-font { font-family: 'Great Vibes', cursive; }
        </style>
    </body>
</html>
