<?php

// app/Models/Category.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'color'];

    public function instruments()
    {
        return $this->belongsToMany(Instrument::class, 'category_instrument');
    }
}
