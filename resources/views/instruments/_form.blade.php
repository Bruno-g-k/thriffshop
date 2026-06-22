{{-- resources/views/instruments/_form.blade.php
     Partial compartilhado entre create e edit. --}}

{{-- Erros de validação --}}
@if($errors->any())
    <div class="bg-red-50 border border-music-red/30 rounded-xl p-4 text-sm text-red-700">
        <p class="font-semibold mb-2">Corrija os erros abaixo:</p>
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Título --}}
<div>
    <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Título *</label>
    <input type="text" id="title" name="title"
           value="{{ old('title', $instrument?->title) }}"
           placeholder="Ex.: Fender Stratocaster American Professional"
           class="w-full border border-amber-300 rounded-xl px-4 py-2.5 text-sm bg-music-bg
                  focus:outline-none focus:ring-2 focus:ring-music-yellow
                  @error('title') border-music-red @enderror">
    @error('title') <p class="text-xs text-music-red mt-1">{{ $message }}</p> @enderror
</div>

{{-- Marca --}}
<div>
    <label for="brand" class="block text-sm font-semibold text-gray-700 mb-1">Marca *</label>
    <input type="text" id="brand" name="brand"
           value="{{ old('brand', $instrument?->brand) }}"
           placeholder="Ex.: Fender, Gibson, Roland"
           class="w-full border border-amber-300 rounded-xl px-4 py-2.5 text-sm bg-music-bg
                  focus:outline-none focus:ring-2 focus:ring-music-yellow
                  @error('brand') border-music-red @enderror">
    @error('brand') <p class="text-xs text-music-red mt-1">{{ $message }}</p> @enderror
</div>

{{-- Preço + Condição (lado a lado) --}}
<div class="grid grid-cols-2 gap-4">
    <div>
        <label for="price" class="block text-sm font-semibold text-gray-700 mb-1">Preço (R$) *</label>
        <input type="number" id="price" name="price" step="0.01" min="1"
               value="{{ old('price', $instrument?->price) }}"
               placeholder="1500.00"
               class="w-full border border-amber-300 rounded-xl px-4 py-2.5 text-sm bg-music-bg
                      focus:outline-none focus:ring-2 focus:ring-music-yellow
                      @error('price') border-music-red @enderror">
        @error('price') <p class="text-xs text-music-red mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        {{-- The Riff Condition --}}
        <label for="condition" class="block text-sm font-semibold text-gray-700 mb-1">Condição *</label>
        <select id="condition" name="condition"
                class="w-full border border-amber-300 rounded-xl px-4 py-2.5 text-sm bg-music-bg
                       focus:outline-none focus:ring-2 focus:ring-music-yellow cursor-pointer
                       @error('condition') border-music-red @enderror">
            <option value="" disabled {{ old('condition', $instrument?->condition) ? '' : 'selected' }}>Selecione…</option>
            @foreach($conditions as $cond)
                <option value="{{ $cond }}" {{ old('condition', $instrument?->condition) === $cond ? 'selected' : '' }}>
                    {{ $cond }}
                </option>
            @endforeach
        </select>
        @error('condition') <p class="text-xs text-music-red mt-1">{{ $message }}</p> @enderror
    </div>
</div>

{{-- Descrição --}}
<div>
    <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Descrição</label>
    <textarea id="description" name="description" rows="5"
              placeholder="Detalhe o estado, acessórios inclusos, histórico do instrumento…"
              class="w-full border border-amber-300 rounded-xl px-4 py-2.5 text-sm bg-music-bg
                     focus:outline-none focus:ring-2 focus:ring-music-yellow resize-none
                     @error('description') border-music-red @enderror">{{ old('description', $instrument?->description) }}</textarea>
    @error('description') <p class="text-xs text-music-red mt-1">{{ $message }}</p> @enderror
</div>

{{-- Categorias --}}
<div>
    <p class="block text-sm font-semibold text-gray-700 mb-2">Categorias</p>
    <div class="flex flex-wrap gap-3">
        @foreach($categories as $category)
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox"
                       id="category-{{ $category->id }}"
                       name="categories[]"
                       value="{{ $category->id }}"
                       {{ in_array($category->id, old('categories', $selectedCategories ?? [])) ? 'checked' : '' }}
                       class="rounded border-amber-300 text-music-yellow focus:ring-music-yellow">
                <span class="text-sm font-medium px-3 py-1 rounded-full text-white"
                      style="background-color: {{ $category->color }}">
                    {{ $category->name }}
                </span>
            </label>
        @endforeach
    </div>
</div>

{{-- Upload de imagens --}}
<div>
    <label class="block text-sm font-semibold text-gray-700 mb-2">
        Fotos
        <span class="text-xs font-normal text-gray-400">(máx. 10 arquivos · 4 MB cada · JPG, PNG, WEBP)</span>
    </label>

    <div class="border-2 border-dashed border-amber-300 rounded-xl p-6 text-center bg-music-bg hover:border-music-yellow transition-colors">
        <input type="file" id="images" name="images[]" multiple accept="image/*"
               class="hidden" onchange="previewImages(this)">
        <label for="images" class="cursor-pointer">
            <p class="text-4xl mb-2">📸</p>
            <p class="text-sm text-gray-600 font-medium">Clique para selecionar fotos</p>
            <p class="text-xs text-gray-400 mt-1">A primeira foto marcada será a capa</p>
        </label>
    </div>

    {{-- Pré-visualização + seleção de capa --}}
    <div id="image-preview" class="mt-4 grid grid-cols-4 gap-3 hidden"></div>

    {{-- Input oculto que guarda o índice da foto de capa --}}
    <input type="hidden" id="cover_index" name="cover_index" value="0">
</div>

<script>
function previewImages(input) {
    const preview = document.getElementById('image-preview');
    preview.innerHTML = '';
    preview.classList.remove('hidden');

    Array.from(input.files).forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = (e) => {
            const wrapper = document.createElement('div');
            wrapper.className = 'relative rounded-xl overflow-hidden cursor-pointer border-4';
            wrapper.style.borderColor = index === 0 ? '#FBBF24' : 'transparent';
            wrapper.dataset.index = index;
            wrapper.title = 'Clique para definir como capa';

            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'w-full aspect-square object-cover';

            const badge = document.createElement('span');
            badge.className = 'absolute bottom-1 left-1 text-[10px] font-bold px-1.5 py-0.5 rounded-full';
            badge.style.backgroundColor = '#FBBF24';
            badge.style.color = '#451A03';
            setCoverBadge(badge, index === 0);

            wrapper.appendChild(img);
            wrapper.appendChild(badge);
            wrapper.addEventListener('click', () => selectCover(index));
            preview.appendChild(wrapper);
        };
        reader.readAsDataURL(file);
    });
}

function setCoverBadge(badge, isCover) {
    badge.textContent    = isCover ? '⭐ Capa' : '';
    badge.style.display  = isCover ? 'inline' : 'none';
}

function selectCover(selectedIndex) {
    document.getElementById('cover_index').value = selectedIndex;
    document.querySelectorAll('#image-preview > div').forEach((el, i) => {
        const isCover            = i === selectedIndex;
        el.style.borderColor     = isCover ? '#FBBF24' : 'transparent';
        const badge              = el.querySelector('span');
        setCoverBadge(badge, isCover);
    });
}
</script>
