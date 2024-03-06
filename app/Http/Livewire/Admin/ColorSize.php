<?php

namespace App\Http\Livewire\Admin;

use App\Models\Color;
use Livewire\Component;
use App\Models\ColorSize as Pivot;

class ColorSize extends Component
{
    public $size;
    public $colors;
    public $color_id;
    public $quantity;
    public $pivot;
    public $pivot_color_id;
    public $pivot_quantity;
    public $open;

    protected $listeners = ['delete'];

    protected $rules = [
        'color_id' => 'required',
        'quantity' => 'required|numeric',
    ];

    public function mount()
    {
        $this->colors = Color::all();
    }

    public function save()
    {
        $this->validate();

        $pivot = Pivot::where('size_id', $this->size->id)
            ->where('color_id', $this->color_id)
            ->first();

        if ($pivot) {
            $pivot->quantity += $this->quantity;
            $pivot->save();
        } else {
            $this->size->colors()->attach($this->color_id, ['quantity' => $this->quantity]);
        }

        $this->reset(['color_id', 'quantity']);
        $this->emit('saved');
        $this->size = $this->size->fresh();
    }

    public function edit(Pivot $pivot)
    {
        $this->pivot = $pivot;
        $this->pivot_color_id = $pivot->color_id;
        $this->pivot_quantity = $pivot->quantity;
        $this->open = true;
    }

    public function update()
    {
        $this->pivot->color_id = $this->pivot_color_id;
        $this->pivot->quantity = $this->pivot_quantity;
        $this->pivot->save();
        $this->size = $this->size->fresh();
        $this->open = false;
    }

    public function delete(Pivot $pivot)
    {
        $pivot->delete();
        $this->size = $this->size->fresh();
    }

    public function render()
    {
        $size_colors = $this->size->colors;

        return view('livewire.admin.color-size', compact('size_colors'));
    }
}
