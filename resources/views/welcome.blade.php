<form method="GET" action="{{ url('/') }}" class="mb-4 flex gap-2">
  
    <input 
        type="text" 
        name="search" 
        value="{{ request('search') }}"
        placeholder="Buscar produto..."
        class="border rounded p-2"
    >

    <select name="type_id" class="border rounded p-2">
        <option value="">Todos os tipos</option>

        @foreach ($types as $type)
            <option 
                value="{{ $type->id }}"
                @selected(request('type_id') == $type->id) >

                {{ $type->name }}
            </option>
        @endforeach
    </select>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
        Filtrar
    </button>

    <br>
     @foreach ($products as $product)
        <div class="border rounded p-4 mb-4">
            <h3>{{ $product->name }}</h3>
        </div>
     @endforeach
</form>