<?php

namespace App\Repositories\Album;

interface AlbumInterface
{
    public function search($params = []);

    public function getHotAlbum($params = []);

    public function getNewAlbum($params = []);

    public function getRankingAlbum($params = []);

    public function getAlbum($id, $params = []);

    public function upViewAlbum($media, $albumsView = []);

    public function getAlbumComment($mediaId, $size = 5);

    public function like($data);

    public function comment($data);

    public function report($data);
}
