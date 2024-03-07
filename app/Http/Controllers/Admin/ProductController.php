<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function files(Request $request, Product $product)
    {
        $request->validate([
            'file' => 'required|image|max:2048'
        ]);

        Storage::put('public/products/' . $product->slug, $request->file('file'));

        $product->images()->create([
            'url' => url('storage/products/' . $product->slug . '/' . $request->file('file')->hashName())
        ]);
    }
}
