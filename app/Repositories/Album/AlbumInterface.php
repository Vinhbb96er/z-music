<?php

namespace App\Repositories\Album;

interface AlbumInterface
{
    public function search($params = []);

    public function getHotAlbum($params = []);

    public function getNewAlbum($params = []);

    public function getRankingAlbum($params = []);

    public function getAlbum($id, $params = []);
}
