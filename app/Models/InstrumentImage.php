<?php

// app/Models/InstrumentImage.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstrumentImage extends Model
{
    use HasFactory;

    protected $fillable = ['instrument_id', 'image_path', 'is_cover'];

    protected $casts = ['is_cover' => 'boolean'];

    public function instrument()
    {
        return $this->belongsTo(Instrument::class);
    }
}
