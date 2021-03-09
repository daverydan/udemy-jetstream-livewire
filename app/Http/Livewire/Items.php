<?php

namespace App\Http\Livewire;

use App\Models\Item;
use Livewire\Component;
use Livewire\WithPagination;

class Items extends Component
{
    use WithPagination;

    public $active;
    public $search;
    public $sortBy = 'id';
    public $sortAsc = true;
    public $confirmingItemDeletion = false;

    protected $queryString = [
        'active' => ['except' => false],
        'search' => ['except' => false],
        'sortBy' => ['except' => 'id'],
        'sortAsc' => ['except' => true],
    ];

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
            })
            ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');
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

    public function sortBy($field)
    {
        if ($field == $this->sortBy) {
            $this->sortAsc = !$this->sortAsc;
        }
        $this->sortBy = $field;
    }

    public function confirmItemDeletion($id)
    {
        $this->confirmingItemDeletion = $id;
    }

    public function deleteItem(Item $item)
    {
        $item->delete();
        $this->confirmingItemDeletion = false;
    }
}
