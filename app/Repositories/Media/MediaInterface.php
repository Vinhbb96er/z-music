<?php

namespace App\Repositories\Media;

interface MediaInterface
{
    public function getHotMedia($params = []);

    public function getNewMedia($params = []);

    public function search($params = []);

    public function getRankingMedia($params = []);

    public function getMedia($id, $params = []);

    public function getMediaForPlaylist($ids, $params = []);

    public function getMediaInAlbum($albumId, $params = []);

    public function getMediaComment($mediaId, $size = 5);

    public function getMediaSuggest($params);

    public function createMedia($data, $dataKinds = [], $dataTags = []);
}
