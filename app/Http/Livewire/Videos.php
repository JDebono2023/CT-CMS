<?php

namespace App\Http\Livewire;

use FFMpeg\FFProbe;
use Livewire\Component;
use App\Models\category;
use App\Models\videoContent;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use FFMpeg\Coordinate\TimeCode;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class Videos extends Component
{
    use WithFileUploads;
    use WithPagination;


    public $modelId, $modalFormVisible, $allVideos, $allCategories, $file_name, $user_file_name, $video, $cat_id,  $cat_id2, $category_id, $modalConfirmDeleteVisible, $iteration, $thumb, $videoModalFormVisible;

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'video.required' => 'Please select a video.',
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
        'video' => 'required',
        'cat_id' => 'required'
    ];


    /**
     * The create function.
     *
     * @return void
     */
    public function create()
    {
        $this->validate();


        if ($this->video) {
            $name = $this->video->getClientOriginalName();
            $video = $this->video->hashName();
            // $destinationPath = '/public/videos';
            // $this->video->storeAs($destinationPath, $video);

            $this->video->storePubliclyAs('canadiantirecms/videos', $video, 's3');

            $filename = pathinfo($video, PATHINFO_FILENAME);
            $thumbName = $filename . '.' . 'png';

            FFMpeg::fromDisk('s3')
                ->open($this->video)
                ->getFrameFromSeconds(4)
                ->export()
                ->toDisk('canadiantirecms/videothumbs')
                ->save($thumbName);
        } else {
            $name = 'noImage.png';
        }

        //eventually for s3 bucket
        // $this->video->storePubliclyAs('CTvideos', $name, 's3');

        $video = videoContent::create([
            'file_name' => $name,
            'user_file_name' => $this->user_file_name,
            'video' => $video,
            'thumb' => $thumbName
        ]);

        $video->category()->attach(['category_id' => $this->cat_id], ['cat_type' => 1]);
        if ($this->cat_id2) {
            $video->category()->attach(['category_id' => $this->cat_id2], ['cat_type' => 2]);
        }


        $this->modalFormVisible = false;
        $this->cleanVars();
    }

    /**
     * The create function.
     *
     * @return void
     */
    public function update()
    {
        // $this->validate();
        $videoUpdate = videoContent::find($this->modelId);

        if ($this->video != $videoUpdate->video) {

            // unlink(storage_path('app/public/videos/' . $videoUpdate->video));
            // unlink(storage_path('app/public/videothumbs/' . $videoUpdate->thumb));
            Storage::disk('s3')->delete('canadiantirecms/videos/' . $videoUpdate->video);
            Storage::disk('s3')->delete('canadiantirecms/videothumbs/' . $videoUpdate->thumb);

            $name = $this->video->getClientOriginalName();
            $data = $this->video->hashName();
            // $destinationPath = '/public/videos';
            // $this->video->storeAs($destinationPath, $data);
            $this->video->storePubliclyAs('canadiantirecms/videos', $data, 's3');

            $filename = pathinfo($data, PATHINFO_FILENAME);
            $thumbName = $filename . '.' . 'png';

            FFMpeg::fromDisk('s3')
                ->open($this->video)
                ->getFrameFromSeconds(4)
                ->export()
                ->toDisk('canadiantirecms/videothumbs')
                ->save($thumbName);
        } else {
            $name = $this->file_name;
            $data = $this->video;
            $thumbName = $this->thumb;
            // $userName = $this->user_file_name;
        }

        //eventually for s3 bucket
        // $this->video->storePubliclyAs('CTvideos', $name, 's3');

        $videoUpdate->update([
            'file_name' => $name,
            'user_file_name' => $this->user_file_name,
            'video' => $data,
            'thumb' => $thumbName
        ]);

        $videoUpdate->category()->detach();
        if ($this->cat_id) {
            $videoUpdate->category()->attach(['category_id' => $this->cat_id], ['cat_type' => 1]);
        }

        if ($this->cat_id2) {
            $videoUpdate->category()->attach(['category_id' => $this->cat_id2], ['cat_type' => 2]);
        }


        $this->modalFormVisible = false;
        $this->cleanVars();
    }



    /**
     * The delete function.
     * @return void
     */
    public function delete()
    {
        $video = videoContent::find($this->modelId);
        // dd($image->image);

        // unlink(public_path('storage/videothumbs/' . $video->thumb));
        // unlink(public_path('storage/videos/' . $video->video));

        Storage::disk('s3')->delete('canadiantirecms/videos/' . $video->video);
        Storage::disk('s3')->delete('canadiantirecms/videothumbs/' . $video->thumb);

        videoContent::destroy($this->modelId);
        $this->modalConfirmDeleteVisible = false;
        $this->resetPage();

        $this->dispatchBrowserEvent('event-notification', [
            'eventName' => 'Deleted Page',
            'eventMessage' => 'The page (' . $this->modelId . ') has been deleted!',
        ]);
    }

    // MODAL CONTROLS

    /**
     * File_name updated automatically to the original file image name
     * @param  mixed $value
     * @return void
     */
    public function updatedVideo($value)
    {
        // $this->validate([
        //     'video' => 'video|nullable', // 1MB Max
        // ]);

        $name = $value->getClientOriginalName();
        // dd($name);
        $this->file_name = $name;
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
     * Shows the video modal
     * @return void
     */
    public function videoShowModal($id)
    {
        $this->modelId = $id;
        $this->videoModalFormVisible = true;
        $this->loadModel();
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
        $data = videoContent::find($this->modelId);
        $this->file_name = $data->file_name;
        $this->user_file_name = $data->user_file_name;
        $this->video = $data->video;
        $this->thumb = $data->thumb;
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
        $this->video = null;
        $this->iteration++;
        $this->file_name = '';
        $this->user_file_name = '';
        $this->cat_id = null;
        $this->cat_id2 = null;
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
        $this->allVideos = videoContent::with('category')->orderBy('file_name', 'asc')->paginate(10);

        $links = $this->allVideos;
        $this->allVideos = collect($this->allVideos->items());


        $this->allCategories = category::with('videoContent')->orderBy('name')->get();

        return view('livewire.videos', ['allVideos' => $this->allVideos, 'allCategories' => $this->allCategories, 'links' => $links]);
    }
}
