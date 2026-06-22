{{-- resources/views/components/thriffshop-layout.blade.php
     Componente anônimo que serve como layout completo do thRIFFt Shop.
     Uso nas views: <x-thriffshop-layout pageTitle="Título">...</x-thriffshop-layout> --}}
@props([
    'pageTitle'       => null,
    'metaDescription' => 'thRIFFt Shop — compre e venda instrumentos musicais usados com preço justo.',
])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $metaDescription }}">

    <title>{{ $pageTitle ? $pageTitle . ' · thRIFFt Shop' : 'thRIFFt Shop' }}</title>

    {{-- Google Fonts: Bebas Neue (display) + Inter (body) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@400;500;600;700&display=swap"
          rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-body antialiased bg-music-bg text-gray-900 min-h-screen flex flex-col">

    {{-- ═══════════════════════ HEADER / NAVBAR ═══════════════════════ --}}
    <header class="bg-music-brown shadow-lg sticky top-0 z-50">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <a href="{{ route('instruments.index') }}"
                   class="font-display text-3xl text-music-yellow tracking-wider hover:opacity-80 transition-opacity shrink-0">
                    thRIFFt<span class="text-white">Shop</span>
                </a>

                {{-- Busca rápida (desktop) --}}
                <form action="{{ route('instruments.index') }}" method="GET"
                      class="hidden md:flex items-center gap-2 flex-1 max-w-md mx-8">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Buscar instrumento ou marca…"
                           class="w-full rounded-full bg-white/10 border border-white/20 text-white
                                  placeholder-white/50 px-4 py-1.5 text-sm focus:outline-none
                                  focus:ring-2 focus:ring-music-yellow transition">
                    <button type="submit"
                            class="bg-music-yellow text-music-brown font-semibold text-sm px-4 py-1.5
                                   rounded-full hover:bg-yellow-500 transition-colors whitespace-nowrap">
                        Buscar
                    </button>
                </form>

                {{-- Links de navegação --}}
                <div class="flex items-center gap-4 text-sm font-medium">
                    <a href="{{ route('instruments.index') }}"
                       class="text-white/80 hover:text-music-yellow transition-colors hidden sm:block">
                        Ver todos
                    </a>

                    @auth
                        <a href="{{ route('instruments.dashboard') }}"
                           class="text-white/80 hover:text-music-yellow transition-colors hidden sm:block">
                            Meus Riffs
                        </a>
                        <a href="{{ route('profile.edit') }}"
                           class="text-white/80 hover:text-music-yellow transition-colors hidden sm:block truncate max-w-[120px]">
                            {{ Auth::user()->name }}
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="hidden sm:block">
                            @csrf
                            <button type="submit"
                                    class="text-white/60 hover:text-music-red transition-colors text-xs">
                                Sair
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                           class="text-white/80 hover:text-music-yellow transition-colors">
                            Entrar
                        </a>
                        <a href="{{ route('register') }}"
                           class="bg-music-yellow text-music-brown font-semibold px-4 py-1.5 rounded-full
                                  hover:bg-yellow-500 transition-colors whitespace-nowrap">
                            Cadastrar
                        </a>
                    @endauth
                </div>
            </div>

            {{-- Busca mobile --}}
            <div class="md:hidden pb-3">
                <form action="{{ route('instruments.index') }}" method="GET" class="flex gap-2">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Buscar…"
                           class="flex-1 rounded-full bg-white/10 border border-white/20 text-white
                                  placeholder-white/50 px-4 py-1.5 text-sm focus:outline-none
                                  focus:ring-2 focus:ring-music-yellow transition">
                    <button type="submit"
                            class="bg-music-yellow text-music-brown font-semibold text-sm px-4 py-1.5
                                   rounded-full hover:bg-yellow-500 transition-colors">
                        🔍
                    </button>
                </form>
            </div>
        </nav>
    </header>

    {{-- ═══════════════════════ FLASH MESSAGES ════════════════════════ --}}
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-800 px-6 py-3 text-sm">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-music-red text-red-800 px-6 py-3 text-sm">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    {{-- ═══════════════════════ CONTEÚDO PRINCIPAL ════════════════════ --}}
    <main class="flex-1">
        {{ $slot }}
    </main>

    {{-- ═══════════════════════ FOOTER ════════════════════════════════ --}}
    <footer class="bg-music-brown text-white/60 text-sm mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8
                    flex flex-col sm:flex-row items-center justify-between gap-4">
            <span class="font-display text-2xl text-music-yellow tracking-wider">
                thRIFFt<span class="text-white">Shop</span>
            </span>
            <p class="text-center">
                Marketplace de instrumentos musicais usados &mdash; feito por músicos, para músicos.
            </p>
            <p>&copy; {{ date('Y') }} thRIFFt Shop</p>
        </div>
    </footer>

</body>
</html>
