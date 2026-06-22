{{-- resources/views/instruments/edit.blade.php --}}
<x-thriffshop-layout pageTitle="Editar Instrumento">

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="font-display text-4xl text-music-brown tracking-wide mb-8">EDITAR INSTRUMENTO</h1>

        <form action="{{ route('instruments.update', $instrument) }}" method="POST" enctype="multipart/form-data"
              class="space-y-6 bg-white rounded-3xl shadow-sm border border-amber-100 p-8">
            @csrf @method('PUT')

            @include('instruments._form', [
                'instrument'         => $instrument,
                'conditions'         => $conditions,
                'categories'         => $categories,
                'selectedCategories' => $selectedCategories,
            ])

            {{-- Status (só aparece na edição) --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1" for="status">Status</label>
                <select id="status" name="status"
                        class="w-full border border-amber-300 rounded-xl px-4 py-2.5 text-sm
                               focus:outline-none focus:ring-2 focus:ring-music-yellow bg-music-bg">
                    <option value="active" {{ $instrument->status === 'active' ? 'selected' : '' }}>Ativo</option>
                    <option value="sold"   {{ $instrument->status === 'sold'   ? 'selected' : '' }}>Vendido</option>
                </select>
            </div>

            <div class="pt-4 flex gap-4">
                <button type="submit" id="btn-submit-edit"
                        class="bg-music-yellow text-music-brown font-bold px-8 py-3 rounded-full uppercase
                               tracking-widest hover:bg-yellow-500 transition-all hover:scale-105 active:scale-95">
                    Salvar alterações
                </button>
                <a href="{{ route('instruments.dashboard') }}"
                   class="text-gray-500 hover:text-gray-700 py-3 transition-colors">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-thriffshop-layout>
