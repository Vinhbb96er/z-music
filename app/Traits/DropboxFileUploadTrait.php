<?php

namespace App\Traits;

use Storage;

trait DropboxFileUploadTrait
{
    public function uploadFile($file)
    {
        $path = Storage::disk('dropbox')->put('public-uploads', $file);
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

    public function deleteFile($path)
    {
        if (Storage::disk('dropbox')->exists($path)) {
            Storage::disk('dropbox')->delete($path);
        }
    }
}
