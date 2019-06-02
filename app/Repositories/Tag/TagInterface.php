<?php

namespace App\Repositories\Tag;

interface TagInterface
{
    public function getAll();

    public function getTagsHot($size);
}
