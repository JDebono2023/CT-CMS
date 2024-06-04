<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\category;
use App\Models\imageContent;

class ClientCategory extends Component
{
    public $category;

    public $search = '';

    public function render()
    {
        $this->category = category::where('visible', '=', 1)->where('id', '!=', 25)->orderBy('name', 'asc')->get();

        $recent = category::where('id', '=', 25)->get();
        // return view('client.CategoryHome', compact('category'));

        return view('livewire.client-category', ['category' => $this->category, 'recent' => $recent]);
    }
}
