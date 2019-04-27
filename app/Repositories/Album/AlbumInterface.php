<?php

namespace App\Repositories\Album;

interface AlbumInterface
{
    public function search($params = []);

    public function getHotAlbum($params = []);
}
