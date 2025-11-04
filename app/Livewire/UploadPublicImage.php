<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;

class UploadPublicImage extends Component
{
    use WithFileUploads;
    public $image;
    #[Validate('nullable|image|max:1024')]
    public $imagePath;
    public $files;

    public function mount()
    {
        $this->getAllImages();
    }

    public function uploadImage()
    {
        $this->validate();
        if ($this->image) {
            $fileName = $this->image->getClientOriginalName();
            $this->imagePath = $this->image->storePubliclyAs('public_images', $fileName, 'public');
            $this->image = null;
            $this->imagePath = null;                
            return redirect()->route('uploadPublicImage', ['imagePath' => $fileName]);
        }
    }

    public function removeImage(string $path)
    {
        $to_remove = $path;
        Storage::disk('public')->delete($to_remove);
        return redirect()->route('uploadPublicImage');

    }
    
    public function restart()
    {
        return redirect()->route('uploadPublicImage');
    }

    public function getAllImages()
    {
        $this->files = Storage::disk('public')->allFiles('public_images');
    }

    public function render()
    {
        return view('livewire.upload-public-image');
    }
}
