<?php

namespace App\Http\Livewire;

use App\Models\imageContent;
use Livewire\Component;

class Search extends Component
{
    public $searchTerm;
    public $imageSearch;

    public function render()
    {
        $this->imageSearch = imageContent::all();

        $searchTerm = '%' . $this->searchTerm . '%';
        $this->imageSearch = imageContent::where('user_file_name', 'like', $searchTerm)->get();
        return view('livewire.search');
    }
}
