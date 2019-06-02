<?php

namespace App\Repositories\Tag;

use App\Repositories\BaseRepository;
use App\Models\Tag;

class TagRepository extends BaseRepository implements TagInterface
{
    public function getModel()
    {
        return Tag::class;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getTagsHot($size)
    {
        return $this->model
            ->join('taggables', 'tags.id', '=', 'taggables.tag_id')
            ->join('media', 'taggables.taggable_id', '=', 'media.id')
            ->selectRaw('tags.*, sum(media.views) as total_view')
            ->groupBy('taggables.tag_id')
            ->orderBy('total_view', 'desc')->paginate($size);
    }
}
