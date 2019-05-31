<?php

namespace App\Repositories\Album;

use App\Repositories\BaseRepository;
use App\Models\Album;

class AlbumRepository extends BaseRepository implements AlbumInterface
{
    public function getModel()
    {
        return Album::class;
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        if (isset($params['type'])) {
            $query->where('type', $params['type']);
        }

        if (!empty($params['is_artist'])) {
            $query->whereHas('user', function($query) {
                $query->where('role_id', config('setting.user.role.artist'));
            });
        }

        if (!empty($params['region'])) {
            $query->where('region_id', $params['region']);
        }

        if (!empty($params['user'])) {
            $query->where('user_id', $params['user']);
        }

        if (isset($params['with_count'])) {
            $query->withCount($params['with_count']);
        }

        if (isset($params['eagle_loading'])) {
            $query->with($params['eagle_loading']);
        }

        if (isset($params['sort_type']) && isset($params['sort_field'])) {
            $query->orderBy($params['sort_field'], $params['sort_type']);
        }

        return isset($params['size']) ? $query->paginate($params['size']) : $query->paginate(10);
    }

    public function getHotAlbum($params = [])
    {
        unset($params['type']);
        $params['is_artist'] = true;
        $params['with_count'] = 'likes';
        $params['sort_field'] = 'likes_count';
        $params['sort_type'] = 'desc';
        $params['eagle_loading'] = [
            'user',
            'kinds',
            'media',
        ];

        return $this->search($params);
    }

    public function getNewAlbum($params = [])
    {
        unset($params['type']);
        $params['is_artist'] = true;
        $params['sort_field'] = 'created_at';
        $params['sort_type'] = 'desc';
        $params['eagle_loading'] = [
            'user',
            'kinds',
            'media',
        ];

        return $this->search($params);
    }

    public function getRankingAlbum($params = [])
    {
        unset($params['type']);
        $params['is_artist'] = true;
        $params['sort_field'] = 'views';
        $params['sort_type'] = 'desc';
        $params['eagle_loading'] = [
            'user',
            'kinds',
        ];

        return $this->search($params);
    }

    public function getAlbum($id, $params = [])
    {
        $query = $this->model->newQuery();

        if (isset($params['eagle_loading'])) {
            if (isset($params['eagle_loading'])) {
                if (!empty($params['load_user_followers'])) {
                    $query->with(['user' => function ($query) {
                        $query->withCount('followers');
                    }]);
                    $params['eagle_loading'] = array_diff($params['eagle_loading'], ['user']);
                }

                if (in_array('comments', $params['eagle_loading'])) {
                    $query->with(['comments' => function ($query) {
                        $query->where('reply_id', 0)->with(['user', 'replies.user']);
                    }]);
                    $params['eagle_loading'] = array_diff($params['eagle_loading'], ['comments']);
                }

                $query->with($params['eagle_loading']);
            }
        }

        if (isset($params['with_count'])) {
            $query->withCount($params['with_count']);
        }

        return $query->findOrFail($id);
    }

    public function upViewAlbum($id)
    {
        $media = $this->model->findOrFail($id);
        $media->update([
            'views' => $media->views + 1
        ]);

        return $media->views;
    }

    public function getAlbumComment($mediaId, $size = 5)
    {
        return $this->model->findOrFail($mediaId)->comments()->where('reply_id', 0)->with(['user', 'replies.user'])->paginate($size);
    }

    public function like($data)
    {
        $album = $this->model->findOrFail($data['id']);
        $like = $album->likes()
            ->where('user_id', Auth::user()->id)
            ->first();

        if ($like) {
            $like->delete();
        } else {
            $album->likes()->create([
                'status' => 1,
                'user_id' => Auth::user()->id,
            ]);
        }

        return $this->model->withCount('likes')->findOrFail($data['id'])->likes_count;
    }
}
