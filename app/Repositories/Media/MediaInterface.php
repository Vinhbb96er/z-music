<?php

namespace App\Repositories\Media;

interface MediaInterface
{
    public function getHotMedia($type = null);

    public function getNewMedia($type = null);
}
