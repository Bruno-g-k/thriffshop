<?php

// app/Http/Controllers/InstrumentController.php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Instrument;
use App\Http\Requests\StoreInstrumentRequest;
use App\Http\Requests\UpdateInstrumentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InstrumentController extends Controller
{
    // ─── Públicas ─────────────────────────────────────────────────────

    /** Lista de instrumentos ativos com busca e filtros via query string. */
    public function index(Request $request)
    {
        $query = Instrument::with(['coverImage', 'categories'])
            ->where('status', Instrument::STATUS_ACTIVE);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        if ($categoryId = $request->input('category')) {
            $query->whereHas('categories', fn ($q) => $q->where('categories.id', $categoryId));
        }

        if ($condition = $request->input('condition')) {
            $query->where('condition', $condition);
        }

        $instruments = $query->latest()->paginate(12);
        $categories  = Category::orderBy('name')->get();

        return view('instruments.index', compact('instruments', 'categories'));
    }

    /** Página de detalhes de um instrumento. */
    public function show(Instrument $instrument)
    {
        // Carrega imagens e categorias do instrumento
        $instrument->load(['images', 'categories', 'user']);

        // Carrega outros itens ativos do mesmo vendedor separadamente
        // para evitar conflito com o relacionamento hasMany global
        $sellerOtherItems = Instrument::with('coverImage')
            ->where('user_id', $instrument->user_id)
            ->where('id', '!=', $instrument->id)
            ->where('status', Instrument::STATUS_ACTIVE)
            ->latest()
            ->limit(4)
            ->get();

        // TODO: integrar com sistema de carrinho/ofertas (fase 2)

        return view('instruments.show', compact('instrument', 'sellerOtherItems'));
    }

    // ─── Autenticadas ─────────────────────────────────────────────────

    /** Dashboard do vendedor: instrumentos do usuário logado. */
    public function dashboard()
    {
        $instruments = auth()->user()
            ->instruments()
            ->with('coverImage')
            ->latest()
            ->get();

        return view('instruments.dashboard', compact('instruments'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $conditions = Instrument::CONDITIONS;

        return view('instruments.create', compact('categories', 'conditions'));
    }

    public function store(StoreInstrumentRequest $request)
    {
        $instrument = auth()->user()->instruments()->create(
            $request->safe()->except(['categories', 'images', 'cover_index'])
        );

        $this->syncCategories($instrument, $request->input('categories', []));
        $this->handleImageUploads($instrument, $request);

        return redirect()->route('instruments.dashboard')
            ->with('success', 'Instrumento anunciado com sucesso! 🎸');
    }

    public function edit(Instrument $instrument)
    {
        $this->authorize('update', $instrument);

        $categories         = Category::orderBy('name')->get();
        $conditions         = Instrument::CONDITIONS;
        $selectedCategories = $instrument->categories()->pluck('categories.id')->toArray();

        return view('instruments.edit', compact('instrument', 'categories', 'conditions', 'selectedCategories'));
    }

    public function update(UpdateInstrumentRequest $request, Instrument $instrument)
    {
        $this->authorize('update', $instrument);

        $instrument->update(
            $request->safe()->except(['categories', 'images', 'cover_index'])
        );

        $this->syncCategories($instrument, $request->input('categories', []));

        if ($request->hasFile('images')) {
            $this->handleImageUploads($instrument, $request);
        }

        return redirect()->route('instruments.dashboard')
            ->with('success', 'Instrumento atualizado com sucesso.');
    }

    public function destroy(Instrument $instrument)
    {
        $this->authorize('delete', $instrument);

        // Remove imagens do storage antes de excluir o registro
        foreach ($instrument->images as $image) {
            // Ignora paths externos (ex: placeholders de URL)
            if (!str_starts_with($image->image_path, 'http')) {
                Storage::disk('public')->delete($image->image_path);
            }
        }

        $instrument->delete();

        return redirect()->route('instruments.dashboard')
            ->with('success', 'Instrumento removido.');
    }

    // ─── Helpers privados ─────────────────────────────────────────────

    private function syncCategories(Instrument $instrument, array $categoryIds): void
    {
        $instrument->categories()->sync($categoryIds);
    }

    private function handleImageUploads(Instrument $instrument, Request $request): void
    {
        $coverIndex = (int) $request->input('cover_index', 0);

        foreach ($request->file('images', []) as $index => $file) {
            $path    = $file->store('instruments', 'public');
            $isCover = ($index === $coverIndex);

            // Ao marcar uma nova capa, desmarca todas as outras deste instrumento
            if ($isCover) {
                $instrument->images()->update(['is_cover' => false]);
            }

            $instrument->images()->create([
                'image_path' => $path,
                'is_cover'   => $isCover,
            ]);
        }

        // Se ainda não há nenhuma capa definida, promove a primeira imagem
        if ($instrument->images()->where('is_cover', true)->doesntExist()) {
            optional($instrument->images()->oldest()->first())->update(['is_cover' => true]);
        }
    }
}
