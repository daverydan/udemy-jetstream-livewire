<?php

namespace App\Http\Livewire;

use App\Models\Item;
use Livewire\Component;
use Livewire\WithPagination;

class Items extends Component
{
    use WithPagination;

    public $active, $search;

    public function render()
    {
        $items = Item::where('user_id', auth()->user()->id)
            ->when($this->search, function ($query) {
                return $query->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('price', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->active, function ($query) {
                return $query->active();
            });
        $query = $items->toSql();
        $items = $items->paginate(10);
        return view('livewire.items', compact('items', 'query'));
    }

    public function updatingActive()
    {
        $this->resetPage();;
    }

    public function updatingSearch()
    {
        $this->resetPage();;
    }
}
