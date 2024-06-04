<?php

namespace App\Http\Livewire;

use App\Models\type;
use App\Models\media;
use Livewire\Component;
use App\Models\category;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class Medias extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $modelId, $allMedia, $allCategories, $file_name, $user_file_name, $media, $cat_id, $cat_id2, $category_id, $type_id, $type, $thumb, $iteration;

    public $addMediaModal, $deleteMediaModal, $mediaPreviewModal;

    public $mediaType = [], $searchTerm, $categoryFilter = [];

    // FILTERING MEDIA -----------------------------------------------------------------


    // reset the pagination after filtering
    public function updatingmediaType()
    {
        $this->resetPage();
    }

    public function updatingcategoryFilter()
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
        $this->reset(['mediaType', 'categoryFilter', 'searchTerm']);
    }

    // VALIDATION -------------------------------------------------------------------------
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'media.required' => 'Please select an image or video.',
            'type_id.required' => 'Please select a media type.',
            'user_file_name.required' => 'A client friendly file name is required.',
            'file_name.required' => 'Please select a video to generate the file name.',
            'cat_id.required' => 'A minimum of one category must be selected.',

        ];
    }

    /**
     * The form validation rules
     *
     * @return void
     */
    protected $rules = [
        'file_name' => 'required',
        'user_file_name' => 'required',
        'media' => 'required',
        'cat_id' => 'required',
        'type_id' => 'required',
        'thumb' => 'nullable'
    ];

    // FUNCTIONS -------------------------------------------------------------------------
    /**
     * The create function.
     *
     * @return void
     */
    public function create()
    {
        $this->validate();

        // hash the media name, and save to AWS
        $name = $this->media->hashName();
        $this->media->storePubliclyAs('canadiantirecms/ctMedia', $name, 's3');

        // if the media is a video, create and save the thumbnail image
        if ($this->media && $this->type_id == 1) {
            $filename = pathinfo($name, PATHINFO_FILENAME);
            $thumbName = $filename . '.' . 'png';

            FFMpeg::fromDisk('ctMedia')
                ->open($this->media)
                ->getFrameFromSeconds(5)
                ->export()
                ->toDisk('awsVideothumbs')
                ->save($thumbName);
        } else {
            $thumbName = null;
        }

        // create the new media item
        $media = media::create([
            'file_name' => $this->media->getClientOriginalName(),
            'user_file_name' => $this->user_file_name,
            'media' => $name,
            'type_id' => $this->type_id,
            'thumb' => $thumbName
        ]);

        // apply category information to the pivot table
        $media->category()->attach(['category_id' => $this->cat_id], ['cat_type' => 1]);
        if ($this->cat_id2) {
            $media->category()->attach(['category_id' => $this->cat_id2], ['cat_type' => 2]);
        }

        $this->addMediaModal = false;
        $this->cleanVars();
    }

    /**
     * File_name updated automatically to the original file image name
     * type_id updated automatically to the file type submitted, based on video or image type
     * @param  mixed $value
     * @return void
     */
    public function updatedMedia($value)
    {
        $this->validate([
            'media' => 'nullable', // 1MB Max
        ]);

        $name = $value->getClientOriginalName();
        $this->file_name = $name;


        $ext = $value->getClientOriginalExtension();
        if ($ext == 'mp4') {
            $this->type_id = 1;
        } else {
            $this->type_id = 2;
        }
    }


    /**
     * The update function.
     * @return void
     */
    public function update()
    {
        $this->validate([
            'file_name' => 'required',
            'user_file_name' => 'required',
            'media' => 'nullable',
            'thumb' => 'nullable'
        ]);

        // locate the media item selected for update
        $media = media::find($this->modelId);

        // check the image data, if it's a new updated image, remove the original version tied to the selected ID and add new ones, else save the existing file information with no changes
        if ($this->media != $media->media) {
            Storage::disk('s3')->delete('canadiantirecms/ctMedia/' . $media->media);
            Storage::disk('s3')->delete('canadiantirecms/videothumbs/' . $media->thumb);
            $name = $this->media->getClientOriginalName();
            $data = $this->media->hashName();

            $this->media->storePubliclyAs('canadiantirecms/ctMedia', $data, 's3');
            // $data = $name;
        } else {
            $name = $this->file_name;
            $data = $this->media;
        }

        // create the thumbnail image from the video for display, if the update contains new media, and the media is a video
        if ($this->media != $media->media && $this->type_id == 1) {
            $filename = pathinfo($name, PATHINFO_FILENAME);
            $thumbName = $filename . '.' . 'png';

            FFMpeg::fromDisk('ctMedia')
                ->open($this->media)
                ->getFrameFromSeconds(5)
                ->export()
                ->toDisk('awsVideothumbs')
                ->save($thumbName);
        } else {
            $thumbName = $this->thumb;
        }

        // update the item
        $media->update([
            'file_name' => $name,
            'user_file_name' => $this->user_file_name,
            'media' => $data,
            'type_id' => $this->type_id,
            'thumb' => $thumbName
        ]);

        // if the category has been changed, remove the existing category information and update based on the received info
        $media->category()->detach();
        if ($this->cat_id) {
            $media->category()->attach(['category_id' => $this->cat_id], ['cat_type' => 1]);
        }

        if ($this->cat_id2) {
            $media->category()->attach(['category_id' => $this->cat_id2], ['cat_type' => 2]);
        }


        $this->addMediaModal = false;
        $this->cleanVars();
    }


    /**
     * The delete function.
     * @return void
     */
    public function delete()
    {
        $media = media::find($this->modelId);

        Storage::disk('s3')->delete('canadiantirecms/ctMedia/' . $media->media);
        Storage::disk('s3')->delete('canadiantirecms/videothumbs/' . $media->thumb);

        media::destroy($this->modelId);
        $this->deleteMediaModal = false;
        $this->resetPage();
    }

    // MODAL FUNCTIONS -------------------------------------------------------------------

    /**
     * On click, close the addMediaModal and clear the form
     * @return void
     */
    public function close()
    {
        $this->cleanVars();
        $this->addMediaModal = false;
    }

    /**
     * Opens addMediaModal
     * @return void
     */
    public function createMediaModal()
    {
        $this->resetValidation();
        $this->cleanVars();
        $this->addMediaModal = true;
    }


    /**
     * Opens updateMediaModal
     * @return void
     */
    public function updateMediaModal($id)
    {
        $this->resetValidation();
        $this->cleanVars();
        $this->modelId = $id;
        $this->addMediaModal = true;
        $this->loadModel();
    }

    /**
     * Opens deleteMediaModal
     * @return void
     */
    public function deleteMediaModal($id)
    {
        $this->modelId = $id;
        $this->deleteMediaModal = true;
    }

    /**
     * Loads the model data of this component.
     * @return void
     */
    public function loadModel()
    {
        $data = media::find($this->modelId);
        $this->file_name = $data->file_name;
        $this->user_file_name = $data->user_file_name;
        $this->media = $data->media;
        $this->type_id = $data->type_id;
        if ($data->thumb) {
            $this->thumb = $data->thumb;
        }

        // dd($this->image);

        foreach ($data->category as $cat) {

            if ($cat->pivot->cat_type == 1) {
                $this->cat_id = $cat->pivot->category_id;
            }

            if ($cat->pivot->cat_type == 2) {
                $this->cat_id2 = $cat->pivot->category_id;
            }
        }
    }

    /**
     * function run to clear the form
     * @return void
     */
    public function cleanVars()
    {
        $this->modelId = null;
        $this->media = null;
        $this->iteration++;
        $this->file_name = '';
        $this->user_file_name = '';
        $this->cat_id = null;
        $this->cat_id2 = null;
        $this->type_id = null;
        $this->thumb = null;
    }

    /**
     * Shows the preview media modal
     * @return void
     */
    public function mediaPreviewModal($id)
    {
        $this->cleanVars();
        $this->modelId = $id;
        $this->mediaPreviewModal = true;
        $this->loadModel();
    }


    // RENDER ----------------------------------------------------------------------------
    public function render()
    {
        $mediaType = $this->mediaType;
        $searchTerm = '%' . $this->searchTerm . '%';
        $categoryFilter = $this->categoryFilter;

        if ($mediaType == null && $searchTerm == null && $categoryFilter == null) {
            $this->allMedia = media::with(['category', 'types'])->orderBy('updated_at', 'desc')->paginate(20);
        } elseif ($searchTerm && !$mediaType && !$categoryFilter) {
            $this->allMedia = media::where('user_file_name', 'like', $searchTerm)->orWhere('file_name', 'like', $searchTerm)->orderBy('updated_at', 'desc')->paginate(20);
        } elseif ($categoryFilter) {
            $this->allMedia = media::whereHas('category', function (Builder $query) {
                $categoryFilter = $this->categoryFilter;
                $query->where('category_id', '=', $categoryFilter);
            })->orderBy('updated_at', 'desc')->paginate(20);
        } elseif ($mediaType) {
            $this->allMedia = media::whereIn('type_id', $mediaType)->orderBy('updated_at', 'desc')->paginate(20);
        }



        $this->allCategories = category::orderBy('name')->get();
        $this->type = type::all();

        $typeList = media::select('type_id')->groupBy('type_id')->get();
        $mediaCategories = category::orderBy('name')->get();

        $links = $this->allMedia;
        $this->allMedia = collect($this->allMedia->items());


        return view('livewire.medias', ['allMedia' => $this->allMedia, 'allCategories' => $this->allCategories, 'type' => $this->type, 'typeList' => $typeList, 'mediaCategories' => $mediaCategories, 'links' => $links]);
    }
}
