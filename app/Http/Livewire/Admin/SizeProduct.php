<?php

namespace App\Http\Livewire\Admin;

use App\Models\Size;
use Livewire\Component;

class SizeProduct extends Component
{
    public $name;
    public $product;
    public $open;
    public $name_edit;
    public $size;

    protected $listeners = ['delete'];

    protected $rules = [
        'name' => 'required|min:3',
    ];

    public function save()
    {
        $this->validate();

        $size = Size::where('product_id', $this->product->id)
            ->where('name', $this->name)
            ->first();

        if ($size) {
            $this->emit('errorSize', 'El tamaño ya existe para este producto.');
        } else {
            $this->product->sizes()->create(['name' => $this->name,]);
        }

        $this->reset('name');
        $this->product = $this->product->fresh();
    }

    public function edit(Size $size)
    {
        $this->name_edit = $size->name;
        $this->size = $size;
        $this->open = true;
    }

    public function update()
    {
        $this->validate([
            'name_edit' => 'required|min:3',
        ]);

        $this->size->name = $this->name_edit;
        $this->size->save();
        $this->product = $this->product->fresh();
        $this->open = false;
    }

    public function delete(Size $size)
    {
        $size->delete();
        $this->product = $this->product->fresh();
    }

    public function render()
    {
        $sizes = $this->product->sizes;
        return view('livewire.admin.size-product', compact('sizes'));
    }
}
