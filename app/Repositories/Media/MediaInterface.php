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

    public function upViewMedia($id);

    public function createMedia($data, $dataKinds = [], $dataTags = []);

    public function updateMedia($id, $data, $dataKinds = [], $dataTags = []);

    public function deleteMedia($id);

    public function like($data);

    public function comment($data);

    public function report($data);

    public function addFavouriteList($user, $id);

    public function removeFavouriteList($user, $id);

    public function getFavouriteList($user, $size);
}
