<?php

namespace App\Traits;

use Storage;
use Auth;

trait FileUploadTrait
{
    public function uploadMediaFile($file)
    {
        $folderName = Auth::user()->id . '_' . explode('@', Auth::user()->email)[0];
        $path = Storage::disk('dropbox')->put($folderName, $file);
        $url = Storage::disk('dropbox')->getDriver()
            ->getAdapter()
            ->getClient()
            ->createSharedLinkWithSettings($path)['url'];

        $url = substr($url, 0, -1) . "1";

        return [
            'path' => $path,
            'url' => $url
        ];
    }

    public function deleteMediaFile($path)
    {
        if (Storage::disk('dropbox')->exists($path)) {
            Storage::disk('dropbox')->delete($path);
        }
    }

    public function uploadImage($file)
    {
        $folderName = Auth::user()->id . '_' . explode('@', Auth::user()->email)[0];
        $path = Storage::disk('public')->put($folderName, $file);

        return $path;
    }

    public function deleteImage($path)
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
