<?php

// app/Models/Instrument.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instrument extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'price',
        'brand',
        'condition',
        'status',
    ];

    /**
     * Valores válidos para "The Riff Condition".
     * Centralizado aqui para reutilizar em Form Requests e views.
     */
    public const CONDITIONS = ['Mint Riff', 'Good Riff', 'Heavy Riff'];

    public const STATUS_ACTIVE = 'active';
    public const STATUS_SOLD   = 'sold';

    // ─── Relacionamentos ──────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_instrument');
    }

    public function images()
    {
        return $this->hasMany(InstrumentImage::class);
    }

    /** Retorna a imagem de capa, ou null se não houver nenhuma. */
    public function coverImage()
    {
        return $this->hasOne(InstrumentImage::class)->where('is_cover', true);
    }
}
