{{-- resources/views/instruments/dashboard.blade.php --}}
<x-thriffshop-layout pageTitle="Meus Riffs">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="font-display text-4xl text-music-brown tracking-wide">MEUS RIFFS</h1>
                <p class="text-gray-500 text-sm mt-1">Gerencie seus anúncios</p>
            </div>
            <a href="{{ route('instruments.create') }}"
               id="btn-new-listing"
               class="bg-music-yellow text-music-brown font-bold px-6 py-3 rounded-full uppercase
                      tracking-widest text-sm hover:bg-yellow-500 transition-all hover:scale-105 active:scale-95 shadow">
                + Novo anúncio
            </a>
        </div>

        @if($instruments->isEmpty())
            <div class="text-center py-24 bg-white rounded-3xl shadow-sm border border-amber-100">
                <p class="text-6xl mb-4">🎸</p>
                <h2 class="font-display text-3xl text-music-brown mb-2">Nenhum instrumento anunciado</h2>
                <p class="text-gray-500 mb-6">Comece a vender agora!</p>
                <a href="{{ route('instruments.create') }}"
                   class="bg-music-yellow text-music-brown font-bold px-8 py-3 rounded-full
                          uppercase tracking-widest hover:bg-yellow-500 transition-all">
                    Anunciar instrumento
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($instruments as $instrument)
                    @php
                        $cover = $instrument->coverImage;
                        $statusClasses = $instrument->status === 'active'
                            ? 'bg-emerald-100 text-emerald-800'
                            : 'bg-gray-200 text-gray-600';
                    @endphp
                    <div id="instrument-row-{{ $instrument->id }}"
                         class="bg-white rounded-2xl shadow-sm border border-amber-100 flex items-center gap-5 p-4
                                hover:shadow-md transition-shadow">

                        {{-- Thumbnail --}}
                        <div class="shrink-0 w-20 h-16 rounded-xl overflow-hidden bg-music-bg">
                            <img src="{{ $cover?->image_path ?? 'https://placehold.co/80x64/451A03/FBBF24?text=📷' }}"
                                 alt="{{ $instrument->title }}"
                                 class="w-full h-full object-cover">
                        </div>

                        {{-- Info --}}
                        <div class="flex-1 min-w-0">
                            <h2 class="font-semibold text-gray-900 truncate">{{ $instrument->title }}</h2>
                            <p class="text-xs text-gray-500">{{ $instrument->brand }} &middot; {{ $instrument->condition }}</p>
                        </div>

                        {{-- Preço --}}
                        <span class="font-display text-2xl text-music-red tracking-wide shrink-0 hidden sm:block">
                            R$&nbsp;{{ number_format($instrument->price, 2, ',', '.') }}
                        </span>

                        {{-- Status --}}
                        <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $statusClasses }} shrink-0">
                            {{ $instrument->status === 'active' ? 'Ativo' : 'Vendido' }}
                        </span>

                        {{-- Ações --}}
                        <div class="flex items-center gap-2 shrink-0">
                            <a href="{{ route('instruments.show', $instrument) }}"
                               class="text-gray-400 hover:text-music-brown transition-colors p-2 rounded-lg
                                      hover:bg-amber-50" title="Ver">
                                👁
                            </a>
                            <a href="{{ route('instruments.edit', $instrument) }}"
                               id="btn-edit-{{ $instrument->id }}"
                               class="text-gray-400 hover:text-music-brown transition-colors p-2 rounded-lg
                                      hover:bg-amber-50" title="Editar">
                                ✏️
                            </a>
                            <form action="{{ route('instruments.destroy', $instrument) }}" method="POST"
                                  onsubmit="return confirm('Remover este instrumento?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        id="btn-delete-{{ $instrument->id }}"
                                        class="text-gray-400 hover:text-music-red transition-colors p-2 rounded-lg
                                               hover:bg-red-50" title="Excluir">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-thriffshop-layout>
