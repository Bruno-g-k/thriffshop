{{-- resources/views/instruments/index.blade.php --}}
<x-thriffshop-layout pageTitle="Instrumentos à Venda">

    {{-- ════════════════════════════════════════════════════════════════
         HERO STRIP — faixa de boas-vindas acima do grid
    ═══════════════════════════════════════════════════════════════════ --}}
    <section class="bg-music-brown text-white py-10 px-4">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-6">
            <div>
                <h1 class="font-display text-5xl sm:text-6xl text-music-yellow tracking-widest leading-none">
                    INSTRUMENTOS
                </h1>
                <p class="text-white/70 mt-2 text-base max-w-xl">
                    Gear de qualidade, preço de músico. Compre de quem toca.
                </p>
            </div>
            @auth
                <a href="{{ route('instruments.create') }}"
                   id="btn-new-instrument"
                   class="shrink-0 bg-music-yellow text-music-brown font-bold px-6 py-3 rounded-full
                          text-sm uppercase tracking-widest hover:bg-yellow-500 transition-all
                          hover:scale-105 active:scale-95 shadow-lg">
                    + Anunciar meu Riff
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="shrink-0 border border-music-yellow text-music-yellow font-bold px-6 py-3
                          rounded-full text-sm uppercase tracking-widest hover:bg-music-yellow
                          hover:text-music-brown transition-all">
                    Entrar para anunciar
                </a>
            @endauth
        </div>
    </section>

    {{-- ════════════════════════════════════════════════════════════════
         FILTROS
    ═══════════════════════════════════════════════════════════════════ --}}
    <section class="bg-white shadow-sm border-b border-amber-200 sticky top-16 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <form action="{{ route('instruments.index') }}" method="GET"
                  class="flex flex-wrap items-center gap-3">

                {{-- Campo de busca --}}
                <div class="flex-1 min-w-[200px]">
                    <input type="text"
                           id="filter-search"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Título, marca…"
                           class="w-full border border-amber-300 rounded-lg px-3 py-2 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-music-yellow bg-music-bg">
                </div>

                {{-- Filtro por categoria --}}
                <div class="min-w-[160px]">
                    <select name="category"
                            id="filter-category"
                            class="w-full border border-amber-300 rounded-lg px-3 py-2 text-sm
                                   focus:outline-none focus:ring-2 focus:ring-music-yellow bg-music-bg
                                   cursor-pointer">
                        <option value="">Todas as categorias</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Filtro por condição --}}
                <div class="min-w-[140px]">
                    <select name="condition"
                            id="filter-condition"
                            class="w-full border border-amber-300 rounded-lg px-3 py-2 text-sm
                                   focus:outline-none focus:ring-2 focus:ring-music-yellow bg-music-bg
                                   cursor-pointer">
                        <option value="">Todas as condições</option>
                        @foreach(\App\Models\Instrument::CONDITIONS as $cond)
                            <option value="{{ $cond }}"
                                {{ request('condition') === $cond ? 'selected' : '' }}>
                                {{ $cond }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit"
                        id="btn-filter-apply"
                        class="bg-music-brown text-white px-5 py-2 rounded-lg text-sm font-semibold
                               hover:bg-opacity-90 transition-colors">
                    Filtrar
                </button>

                @if(request()->hasAny(['search', 'category', 'condition']))
                    <a href="{{ route('instruments.index') }}"
                       id="btn-filter-clear"
                       class="text-sm text-gray-500 hover:text-music-red transition-colors underline">
                        Limpar filtros
                    </a>
                @endif
            </form>
        </div>
    </section>

    {{-- ════════════════════════════════════════════════════════════════
         GRID DE INSTRUMENTOS
    ═══════════════════════════════════════════════════════════════════ --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        @if($instruments->isEmpty())
            {{-- Estado vazio --}}
            <div class="text-center py-24">
                <p class="text-7xl mb-4">🎸</p>
                <h2 class="font-display text-4xl text-music-brown tracking-wide mb-2">
                    Nenhum riff por aqui ainda
                </h2>
                <p class="text-gray-500 mb-8">Tente outros filtros ou seja o primeiro a anunciar!</p>
                @auth
                    <a href="{{ route('instruments.create') }}"
                       class="bg-music-yellow text-music-brown font-bold px-8 py-3 rounded-full
                              uppercase tracking-widest hover:bg-yellow-500 transition-all
                              hover:scale-105 active:scale-95">
                        Anunciar instrumento
                    </a>
                @endauth
            </div>
        @else
            {{-- Contador de resultados --}}
            <p class="text-sm text-gray-500 mb-6">
                {{ $instruments->total() }} instrumento{{ $instruments->total() !== 1 ? 's' : '' }} encontrado{{ $instruments->total() !== 1 ? 's' : '' }}
            </p>

            {{-- Grid responsivo: 1 col mobile → 2 tablet → 4 desktop --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($instruments as $instrument)
                    @php
                        $cover = $instrument->coverImage;
                        // Badge de condição: Mint Riff = verde, Good Riff = amarelo, Heavy Riff = vermelho
                        $conditionClasses = match($instrument->condition) {
                            'Mint Riff'  => 'bg-emerald-100 text-emerald-800 border border-emerald-300',
                            'Good Riff'  => 'bg-amber-100  text-amber-800  border border-amber-300',
                            'Heavy Riff' => 'bg-music-red/10 text-music-red border border-music-red/30',
                            default      => 'bg-gray-100 text-gray-700',
                        };
                    @endphp

                    <article id="instrument-card-{{ $instrument->id }}"
                             class="bg-white rounded-2xl shadow-md overflow-hidden group
                                    hover:shadow-xl hover:-translate-y-1 transition-all duration-300
                                    border border-amber-100">

                        {{-- Foto de capa --}}
                        <a href="{{ route('instruments.show', $instrument) }}"
                           class="block relative overflow-hidden aspect-[4/3]">
                            <img src="{{ $cover ? $cover->image_path : 'https://placehold.co/400x300/451A03/FBBF24?text=Sem+foto' }}"
                                 alt="{{ $instrument->title }}"
                                 loading="lazy"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">

                            {{-- Badge de condição sobre a imagem --}}
                            <span class="absolute top-2 left-2 text-xs font-semibold px-2 py-1
                                         rounded-full {{ $conditionClasses }} backdrop-blur-sm">
                                {{ $instrument->condition }}
                            </span>
                        </a>

                        {{-- Corpo do card --}}
                        <div class="p-4">
                            {{-- Categorias --}}
                            <div class="flex flex-wrap gap-1 mb-2">
                                @foreach($instrument->categories->take(2) as $cat)
                                    <span class="text-[10px] font-bold uppercase tracking-widest px-2 py-0.5 rounded-full text-white"
                                          style="background-color: {{ $cat->color }}">
                                        {{ $cat->name }}
                                    </span>
                                @endforeach
                            </div>

                            {{-- Título --}}
                            <h2 class="font-semibold text-gray-900 text-sm leading-snug line-clamp-2 mb-1
                                       group-hover:text-music-brown transition-colors">
                                <a href="{{ route('instruments.show', $instrument) }}">
                                    {{ $instrument->title }}
                                </a>
                            </h2>

                            {{-- Marca --}}
                            <p class="text-xs text-gray-500 mb-3">{{ $instrument->brand }}</p>

                            {{-- Preço + CTA --}}
                            <div class="flex items-end justify-between">
                                <span class="font-display text-2xl text-music-red tracking-wide">
                                    R$&nbsp;{{ number_format($instrument->price, 2, ',', '.') }}
                                </span>
                                <a href="{{ route('instruments.show', $instrument) }}"
                                   class="text-xs font-semibold text-music-brown hover:text-music-yellow
                                          transition-colors underline underline-offset-2">
                                    Ver detalhes →
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- ── Paginação ── --}}
            @if($instruments->hasPages())
                <div class="mt-10 flex justify-center">
                    {{-- Links de paginação com classes customizadas via Tailwind --}}
                    <div class="pagination-thriffт">
                        {{ $instruments->withQueryString()->links('pagination::tailwind') }}
                    </div>
                </div>
            @endif
        @endif
    </section>
</x-thriffshop-layout>

<style>
    /* Override das classes de paginação do Tailwind para seguir o tema */
    .pagination-thriffт nav span[aria-current="page"] > span,
    .pagination-thriffт nav a:hover {
        background-color: #451A03;
        color: #FBBF24;
        border-color: #451A03;
    }
</style>
