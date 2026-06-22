{{-- resources/views/instruments/create.blade.php --}}
<x-thriffshop-layout pageTitle="Anunciar Instrumento">

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="font-display text-4xl text-music-brown tracking-wide mb-8">ANUNCIAR INSTRUMENTO</h1>

        <form action="{{ route('instruments.store') }}" method="POST" enctype="multipart/form-data"
              class="space-y-6 bg-white rounded-3xl shadow-sm border border-amber-100 p-8">
            @csrf

            @include('instruments._form', ['instrument' => null, 'conditions' => $conditions, 'categories' => $categories, 'selectedCategories' => []])

            <div class="pt-4 flex gap-4">
                <button type="submit" id="btn-submit-create"
                        class="bg-music-yellow text-music-brown font-bold px-8 py-3 rounded-full uppercase
                               tracking-widest hover:bg-yellow-500 transition-all hover:scale-105 active:scale-95">
                    Publicar anúncio
                </button>
                <a href="{{ route('instruments.dashboard') }}"
                   class="text-gray-500 hover:text-gray-700 py-3 transition-colors">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-thriffshop-layout>
