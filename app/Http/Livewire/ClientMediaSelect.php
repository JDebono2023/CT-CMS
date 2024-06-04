<?php

namespace App\Http\Livewire;

use App\Models\media;
use Livewire\Component;
use App\Models\category;
use Livewire\WithPagination;
use App\Mail\MediaRequestELM;
use App\Models\MediaRequests;
use App\Mail\MediaRequestClient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Database\Eloquent\Builder;
use ProtoneMedia\LaravelFFMpeg\Filesystem\Media as FilesystemMedia;

class ClientMediaSelect extends Component
{
    use WithPagination;

    public $allMedia, $media, $modelId, $catId, $user_file_name, $file_name, $store_id, $store_name, $starts_at, $ends_at, $edits, $device, $edit_text, $email, $cat, $mediaRequest, $no_end, $thumb, $order_number, $confirm, $type_id;

    public $mediaPreviewModal, $mediaRequestModal;

    public category $category;
    public $searchTerm, $cMediaType = [];


    // FILTERING

    public function updatingcMediaType()
    {
        $this->resetPage();
    }

    public function updatingsearchTerm()
    {
        $this->resetPage();
    }

    // reset ALL FILTERS on button click
    public function resetFilters()
    {
        $this->reset(['cMediaType', 'searchTerm']);
    }

    // FUNCTIONS ----------------------------------------------------------------

    /**
     * The form validation rules
     *
     * @return void
     */
    protected $rules = [
        'starts_at' => 'required',
        'ends_at' => 'nullable',

    ];

    /**
     * Capture the category ID for the request
     *
     * @return void
     */
    public function mount($id)
    {
        $this->category = category::findOrFail($id);
    }


    /**
     * The create request function.
     * @return void
     */
    public function createMessage()
    {
        $this->validate();

        if (($this->no_end == 1 && $this->ends_at == '') || $this->ends_at == '') {
            $this->ends_at = null;
            $end = $this->ends_at;
        } else {
            $end = $this->ends_at;
        }

        $request = MediaRequests::create([
            'file_name' => $this->file_name,
            'user_file_name' => $this->user_file_name,
            'type_id' => $this->type_id,
            'store_id' => $this->store_id,
            'store_name' => $this->store_name,
            'confirm' => $this->confirm,
            'edits' => $this->edits,
            'edit_text' => $this->edit_text,
            'starts_at' => $this->starts_at,
            'ends_at' => $end,
            'no_end' => $this->no_end,
            // 'device' => $this->device,
            'category' => $this->category->name
        ]);

        $file = MediaRequests::find($request->id);
        $user = Auth::user();

        Mail::send(new MediaRequestELM($file, $user));
        Mail::send(new MediaRequestClient($file, $user));


        $this->cleanVars();
        $this->mediaRequestModal = false;
    }

    // MODAL CONTROLS ----------------------------------------------------------------

    /**
     * Shows the preview media modal
     * @return void
     */
    public function mediaPreviewModal($id)
    {
        $this->modelId = $id;
        $this->mediaPreviewModal = true;
        $this->loadPreview();
    }

    /**
     * Loads the preview media.
     * @return void
     */
    public function loadPreview()
    {
        $data = media::find($this->modelId);
        $this->file_name = $data->file_name;
        $this->user_file_name = $data->user_file_name;
        $this->media = $data->media;
        $this->type_id = $data->type_id;
        // dd($this->media);
    }

    /**
     * Close the media preview modal
     * @return void
     */
    public function closePreview()
    {
        // $this->cleanVars();
        $this->mediaPreviewModal = false;
        $this->cleanVars();
    }

    /**
     * Open the media request modal
     * @return void
     */
    public function mediaRequestModal($id)
    {
        $this->resetValidation();
        $this->cleanVars();
        $this->modelId = $id;
        $this->mediaRequestModal = true;
        // dd($this->modelId);
        $this->loadMediaModel();
    }

    /**
     * Loads the model data of this component.
     * @return void
     */
    public function loadMediaModel()
    {
        $data = media::find($this->modelId);
        // dd($data);
        $this->file_name = $data->file_name;
        $this->user_file_name = $data->user_file_name;
        $this->media = $data->media;
        $this->type_id = $data->types->name;
        $this->thumb = $data->thumb;
    }

    /**
     * Close the media request modal
     * @return void
     */
    public function closeMediaRequest()
    {
        $this->cleanVars();
        // $this->reset();
        $this->mediaRequestModal = false;
    }

    /**
     * function run to clear the request form
     * @return void
     */
    public function cleanVars()
    {
        $this->modelId = null;
        $this->media = null;
        $this->type_id = null;
        $this->file_name = '';
        $this->user_file_name = '';
        $this->store_id = '';
        $this->store_name = '';
        $this->confirm = 0;
        $this->edits = 0;
        $this->edit_text = '';
        $this->starts_at = '';
        $this->ends_at = '';
        // $this->device = null;
        $this->no_end = 0;
    }

    // RENDER ----------------------------------------------------------------

    public function render()
    {

        foreach (Auth::user()->teams as $team) {
            $this->store_id = $team->store_number;
            $this->store_name = $team->name;
        }

        $mediaType = $this->cMediaType;
        $searchTerm = '%' . $this->searchTerm . '%';
        $category_id = $this->category->id;

        // Query the media items with the specified category ID and search term filter
        $this->allMedia = media::whereHas('category', function ($query) use ($category_id, $searchTerm, $mediaType) {
            $query->where('categories.id', $category_id);
        })
            ->with('category')
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($query) use ($searchTerm) {
                    $query->where('user_file_name', 'like', $searchTerm)
                        ->orWhere('file_name', 'like', $searchTerm);
                });
            })
            ->when($mediaType, function ($query) use ($mediaType) {
                $query->where(function ($query) use ($mediaType) {
                    $query->where('type_id', $mediaType);
                });
            })
            ->orderBy('updated_at', 'asc')
            ->paginate(20);


        $cTypeList = media::select('type_id')->groupBy('type_id')->get();

        $links = $this->allMedia;
        $this->allMedia = collect($this->allMedia->items());

        return view('livewire.client-media-select', ['allMedia' => $this->allMedia, 'store_id' => $this->store_id, 'cTypeList' => $cTypeList, 'store_name' => $this->store_name, 'category' => $this->category, 'links' => $links]);
    }
}
