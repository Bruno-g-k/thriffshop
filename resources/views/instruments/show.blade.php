{{-- resources/views/instruments/show.blade.php --}}
<x-thriffshop-layout :pageTitle="$instrument->title">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Breadcrumb --}}
        <nav class="text-sm text-gray-500 mb-6 flex items-center gap-2">
            <a href="{{ route('instruments.index') }}"
               class="hover:text-music-brown transition-colors">Instrumentos</a>
            <span aria-hidden="true">›</span>
            <span class="text-gray-800 truncate max-w-[260px]">{{ $instrument->title }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

            {{-- ── GALERIA ──────────────────────────────────────────── --}}
            <div class="space-y-4">
                {{-- Foto principal --}}
                <div class="rounded-2xl overflow-hidden bg-white shadow-md aspect-[4/3]">
                    @php
                        $cover = $instrument->images->firstWhere('is_cover', true)
                              ?? $instrument->images->first();
                    @endphp
                    <img id="main-photo"
                         src="{{ $cover?->image_path ?? 'https://placehold.co/800x600/451A03/FBBF24?text=Sem+foto' }}"
                         alt="{{ $instrument->title }}"
                         class="w-full h-full object-cover">
                </div>

                {{-- Miniaturas (só se houver mais de uma imagem) --}}
                @if($instrument->images->count() > 1)
                    <div class="flex gap-3 flex-wrap">
                        @foreach($instrument->images as $image)
                            <button type="button"
                                    onclick="document.getElementById('main-photo').src = '{{ $image->image_path }}'"
                                    class="rounded-xl overflow-hidden w-20 h-16 border-2 border-transparent
                                           hover:border-music-yellow transition-all focus:outline-none
                                           focus:border-music-yellow shrink-0">
                                <img src="{{ $image->image_path }}"
                                     alt="Miniatura"
                                     class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- ── DETALHES ─────────────────────────────────────────── --}}
            <div class="space-y-6">

                {{-- Categorias --}}
                @if($instrument->categories->isNotEmpty())
                    <div class="flex flex-wrap gap-2">
                        @foreach($instrument->categories as $cat)
                            <span class="text-xs font-bold uppercase tracking-widest px-3 py-1
                                         rounded-full text-white"
                                  style="background-color: {{ $cat->color }}">
                                {{ $cat->name }}
                            </span>
                        @endforeach
                    </div>
                @endif

                {{-- Título --}}
                <h1 class="font-display text-4xl text-music-brown tracking-wide leading-tight">
                    {{ $instrument->title }}
                </h1>

                {{-- Marca + Badge de condição --}}
                <div class="flex items-center gap-4 flex-wrap">
                    <span class="text-gray-600 font-medium">{{ $instrument->brand }}</span>

                    @php
                        $conditionClasses = match($instrument->condition) {
                            'Mint Riff'  => 'bg-emerald-100 text-emerald-800 border border-emerald-300',
                            'Good Riff'  => 'bg-amber-100   text-amber-800   border border-amber-300',
                            'Heavy Riff' => 'bg-red-100     text-red-700     border border-red-300',
                            default      => 'bg-gray-100    text-gray-700    border border-gray-300',
                        };
                    @endphp
                    <span class="text-sm font-semibold px-3 py-1 rounded-full {{ $conditionClasses }}">
                        {{ $instrument->condition }}
                    </span>
                </div>

                {{-- Preço --}}
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-amber-100">
                    <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Preço</p>
                    <p class="font-display text-5xl text-music-red tracking-wide">
                        R$&nbsp;{{ number_format($instrument->price, 2, ',', '.') }}
                    </p>
                </div>

                {{-- CTA Buttons — visuais apenas (fase 2) --}}
                {{-- TODO: integrar com sistema de carrinho/ofertas (fase 2) --}}
                <div class="flex flex-col sm:flex-row gap-3">
                    <button id="btn-add-to-cart" type="button"
                            class="flex-1 bg-music-yellow text-music-brown font-bold py-3 rounded-full
                                   uppercase tracking-widest text-sm hover:bg-yellow-500 transition-all
                                   hover:scale-105 active:scale-95 shadow">
                        🛒 Adicionar ao carrinho
                    </button>
                    <button id="btn-make-offer" type="button"
                            class="flex-1 border-2 border-music-brown text-music-brown font-bold py-3
                                   rounded-full uppercase tracking-widest text-sm hover:bg-music-brown
                                   hover:text-white transition-all">
                        💬 Fazer oferta
                    </button>
                </div>

                {{-- Descrição --}}
                @if($instrument->description)
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-amber-100">
                        <h2 class="font-semibold text-gray-500 mb-3 uppercase tracking-widest text-xs">
                            Descrição
                        </h2>
                        <p class="text-gray-700 leading-relaxed whitespace-pre-line text-sm">
                            {{ $instrument->description }}
                        </p>
                    </div>
                @endif

                {{-- Vendedor --}}
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-amber-100">
                    <h2 class="font-semibold text-gray-500 mb-3 uppercase tracking-widest text-xs">
                        Vendedor
                    </h2>

                    <div class="flex items-center gap-4">
                        {{-- Avatar com inicial --}}
                        <div class="w-12 h-12 bg-music-brown rounded-full flex items-center justify-center
                                    text-music-yellow font-display text-xl shrink-0">
                            {{ strtoupper(mb_substr($instrument->user->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="font-semibold text-gray-900">{{ $instrument->user->name }}</p>
                            @if($instrument->user->bio)
                                <p class="text-xs text-gray-500 mt-0.5 line-clamp-1">
                                    {{ $instrument->user->bio }}
                                </p>
                            @endif
                        </div>
                    </div>

                    {{-- Outros itens do vendedor (variável própria do controller) --}}
                    @if($sellerOtherItems->isNotEmpty())
                        <div class="mt-4 pt-4 border-t border-amber-100">
                            <p class="text-xs text-gray-500 mb-3 uppercase tracking-widest">
                                Mais itens deste vendedor
                            </p>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach($sellerOtherItems as $other)
                                    <a href="{{ route('instruments.show', $other) }}"
                                       class="flex items-center gap-2 p-2 rounded-xl hover:bg-amber-50
                                              transition-colors group">
                                        <div class="w-10 h-10 rounded-lg overflow-hidden shrink-0 bg-amber-100">
                                            <img src="{{ $other->coverImage?->image_path ?? 'https://placehold.co/40x40/451A03/FBBF24?text=🎸' }}"
                                                 alt="{{ $other->title }}"
                                                 class="w-full h-full object-cover">
                                        </div>
                                        <span class="text-xs text-gray-700 group-hover:text-music-brown
                                                     transition-colors line-clamp-2 leading-tight">
                                            {{ $other->title }}
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

</x-thriffshop-layout>
