<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    const BORRADOR = 1;
    const PUBLICADOR = 2;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    // Relación uno a muchos
    public function sizes()
    {
        return $this->hasMany(Size::class);
    }

    // Relación uno a muchos inversa
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    // Relación muchos a muchos
    public function colors()
    {
        return $this->belongsToMany(Color::class)->withPivot('quantity');
    }

    // Relación uno a muchos polimórfica
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    // Url amigable
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
