<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    const BORRADOR = 1;
    const PUBLICADOR = 2;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    // Accesores
    public function getStockAttribute()
    {
        if ($this->subcategory->size) {
            return ColorSize::whereHas('size.product', function (Builder $query) {
                $query->where('id', $this->id);
            })->sum('quantity');
        } elseif ($this->subcategory->color) {
            return ColorProduct::whereHas('product', function (Builder $query) {
                $query->where('id', $this->id);
            })->sum('quantity');
        } else {
            return $this->quantity;
        }
    }

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
