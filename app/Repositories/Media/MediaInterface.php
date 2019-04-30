<?php

namespace App\Repositories\Media;

interface MediaInterface
{
    public function getHotMedia($params = []);

    public function getNewMedia($params = []);

    public function search($params = []);

    public function getRankingMedia($params = []);
}
