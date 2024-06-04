<?php

namespace App\Http\Livewire;

use App\Models\Team;
use Livewire\Component;
use Livewire\WithPagination;

class TeamDash extends Component
{
    use WithPagination;

    public $teams, $modalFormVisible;

    // MODAL CONTROLS********************************************

    /**
     * On click, close modal and clear the form
     * @return void
     */
    public function close()
    {
        // $this->cleanVars();
        $this->modalFormVisible = false;
    }

    /**
     * Shows the create modal
     * @return void
     */
    public function createShowModal()
    {
        // $this->resetValidation();
        // $this->cleanVars();
        $this->modalFormVisible = true;
    }

    public function render()
    {
        $this->teams = Team::paginate(10);

        $links = $this->teams;
        $this->teams = collect($this->teams->items());

        return view('livewire.team-dash', [
            'teams' =>  $this->teams, 'links' => $links
        ]);
    }
}
