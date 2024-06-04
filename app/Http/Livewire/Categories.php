<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\category;
use App\Models\videoContent;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Categories extends Component
{
    use WithFileUploads;
    use WithPagination;


    public $modelId, $modalFormVisible,
        $allCategories, $name, $visible = 0, $image, $file_name,
        $modalConfirmDeleteVisible, $iteration;

    /**
     * The form validation rules
     *
     * @return void
     */
    protected $rules = [
        'name' => 'required',
        'visible' => 'nullable',
        'image' => 'image|required',
    ];


    /**
     * The create function.
     *
     * @return void
     */
    public function create()
    {
        $this->validate();


        // original AWS
        if ($this->image) {
            $this->file_name = $this->image->getClientOriginalName();
            $name = $this->image->hashName();
            $this->image->storePubliclyAs('canadiantirecms/categoryimages', $name, 's3');
        } else {
            $name = 'noImage.png';
        }

        $image = category::create([
            'name' => $this->name,
            'visible' => $this->visible,
            'image' => $name,
            'file_name' => $this->file_name
        ]);

        $this->modalFormVisible = false;
        $this->cleanVars();
    }


    /**
     * The update function.
     * @return void
     */
    public function update()
    {
        $this->validate([
            'name' => 'required',
            'visible' => 'nullable',
            'image' => 'nullable',
        ]);

        $image = category::find($this->modelId);

        // AWS-s3 version
        if ($this->image != $image->image) {

            Storage::disk('s3')->delete('canadiantirecms/categoryimages/' . $image->image);
            $this->file_name = $this->image->getClientOriginalName();
            $name = $this->image->hashName();
            $this->image->storePubliclyAs('canadiantirecms/categoryimages', $name, 's3');
            $data = $name;
        } else {
            $data = $this->image;
        }

        $image->update([
            'name' => $this->name,
            'visible' => $this->visible,
            'image' => $data,
            'file_name' => $this->file_name
        ]);


        $this->modalFormVisible = false;
        $this->cleanVars();
    }

    /**
     * The delete function.
     * @return void
     */
    public function delete()
    {
        $image = category::find($this->modelId);
        // dd($image->image);
        Storage::disk('s3')->delete('canadiantirecms/categoryimages/' . $image->image);

        category::destroy($this->modelId);
        $this->modalConfirmDeleteVisible = false;
        $this->resetPage();
    }

    // Modal Functions ******************************************************

    /**
     * Shows the create modal
     * @return void
     */
    public function createShowModal()
    {
        $this->resetValidation();
        $this->cleanVars();
        $this->modalFormVisible = true;
    }

    /**
     * Shows the form modal in update mode.
     * @param  mixed $id
     * @return void
     */
    public function updateShowModal($id)
    {
        $this->resetValidation();
        $this->cleanVars();
        $this->modelId = $id;
        $this->modalFormVisible = true;
        $this->loadModel();
    }

    /**
     * Loads the model data of this component.
     * @return void
     */
    public function loadModel()
    {
        $data = category::find($this->modelId);
        $this->name = $data->name;
        $this->visible = $data->visible;
        $this->image = $data->image;
        // dd($this->image);
    }

    /**
     * On click, close modal and clear the form
     * @return void
     */
    public function close()
    {
        $this->cleanVars();
        $this->modalFormVisible = false;
    }

    /**
     * function run to clear the form
     * @return void
     */
    public function cleanVars()
    {
        $this->modelId = null;
        $this->image = null;
        $this->iteration++;
        $this->name = '';
        $this->visible = null;
    }

    /**
     * Shows the delete confirmation modal.
     * @param  mixed $id
     * @return void
     */
    public function deleteShowModal($id)
    {
        $this->modelId = $id;
        $this->modalConfirmDeleteVisible = true;
    }

    public function render()
    {

        $this->allCategories = category::with('media')->orderBy('name')->paginate(15);

        $links =  $this->allCategories;
        $this->allCategories = collect($this->allCategories->items());

        return view('livewire.categories', ['allCategories' => $this->allCategories, 'links' => $links]);
    }
}
