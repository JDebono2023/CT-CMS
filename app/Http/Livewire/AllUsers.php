<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Team;
use App\Actions\Jetstream\DeleteUser;
use Laravel\Jetstream\Contracts\DeletesUsers;
use Livewire\Component;
use Livewire\WithPagination;

class AllUsers extends Component
{
    use WithPagination;

    public $modalFormVisible;
    public $modalConfirmDeleteVisible;
    public $modelId;
    public $allUsers;
    public $role;
    public $name;
    // public $user;


    /**
     * The validation rules
     *
     * @return void
     */
    public function rules()
    {
        return [
            'role' => 'required',
            'name' => 'required',
        ];
    }


    /**
     * Shows the delete confirmation modal.
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteShowModal($id)
    {
        $this->modelId = $id;
        $this->modalConfirmDeleteVisible = true;
        $this->loadModel();
    }

    /**
     * Loads the model data
     * of this component.
     *
     * @return void
     */
    public function loadModel()
    {
        $data = User::find($this->modelId);
        $this->role = $data->role;
        $this->name = $data->name;
    }


    /**
     * The delete function.
     *
     * @return void
     */
    public function delete()
    {
        $deleter = resolve(DeletesUsers::class);
        $deleter->delete(User::find($this->modelId));

        $this->modalConfirmDeleteVisible = false;
        $this->resetPage();
    }


    public function render()
    {

        $this->allUsers = User::paginate(10);

        $links = $this->allUsers;
        $this->allUsers = collect($this->allUsers->items());

        return view('livewire.all-users', ['allUsers' => $this->allUsers, 'links' => $links]);
    }
}
