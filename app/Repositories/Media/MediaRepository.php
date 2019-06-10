<?php

namespace App\Repositories\Media;

use App\Repositories\BaseRepository;
use App\Models\Media;
use Auth;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class MediaRepository extends BaseRepository implements MediaInterface
{
    public function getModel()
    {
        return Media::class;
    }

    public function getHotMedia($params = [])
    {
        $params['is_artist'] = true;
        $params['with_count'] = 'likes';
        $params['sort_field'] = 'likes_count';
        $params['sort_type'] = 'desc';
        $params['eagle_loading'] = [
            'user',
            'kinds',
        ];

        return $this->search($params);
    }

    public function getNewMedia($params = [])
    {
        $params['is_artist'] = true;
        $params['sort_field'] = 'created_at';
        $params['sort_type'] = 'desc';
        $params['eagle_loading'] = [
            'user',
            'kinds',
        ];

        return $this->search($params);
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        if (!empty($params['keyword'])) {
            $query->where(function($subQuery) use ($params) {
                $subQuery->orWhere('media.name', 'like', '%' . $params['keyword'] . '%');
            });
        }

        if (isset($params['type'])) {
            $query->where('type', $params['type']);
        }

        if (isset($params['status'])) {
            if ($params['status'] != 0) {
                $query->where('media.status', $params['status']);
            }
        } else {
            $query->where('media.status', 1);
        }

        if (!empty($params['is_artist'])) {
            $query->whereHas('user', function($query) {
                $query->where('role_id', config('setting.user.role.artist'));
            });
        }

        if (!empty($params['report'])) {
            $query->has('reports')->with('reports');
        }

        if (!empty($params['user'])) {
            $query->where('user_id', $params['user']);
        }

        if (!empty($params['region'])) {
            $query->where('region_id', $params['region']);
        }

        if (!empty($params['kind'])) {
            $query->whereHas('kinds', function($query) use ($params) {
                $query->where('kinds.id', $params['kind']);
            });
        }

        if (!empty($params['tag'])) {
            $query->whereHas('tags', function($query) use ($params) {
                $query->where('tags.id', $params['tag']);
            });
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

        if (!empty($params['first_artist'])) {
            $query->join('users', 'media.user_id', '=', 'users.id')->orderBy('role_id', 'desc')->select('media.*');
        }

        return isset($params['size']) ? $query->paginate($params['size']) : $query->paginate(10);
    }

    public function getRankingMedia($params = [])
    {
        $query = $this->model->newQuery();

        $query->where('type', $params['type']);
        $eagleLoading = ['user'];

        if (!empty($params['full_loading'])) {
            $eagleLoading = ['user', 'kinds', 'region'];
        }

        $query->with($eagleLoading);
        $size = isset($params['size']) ? $params['size'] : 10;

        if (isset($params['week'])) {
            $firstDateOfWeek = Carbon::parse($params['week'])->startOfWeek();
            $lastDateOfWeek = Carbon::parse($params['week'])->endOfWeek();
            $oldFirstDateOfWeek = Carbon::parse($params['week'])->subWeek(1)->startOfWeek();
            $oldLastDateOfWeek = Carbon::parse($params['week'])->subWeek(1)->endOfWeek();
        } else {
            $firstDateOfWeek = Carbon::now()->startOfWeek();
            $lastDateOfWeek = Carbon::now()->endOfWeek();
            $oldFirstDateOfWeek = Carbon::now()->subWeek(1)->startOfWeek();
            $oldLastDateOfWeek = Carbon::now()->subWeek(1)->endOfWeek();
        }

        $newData = $query->join('weeky_views', 'media.id', '=', 'weeky_views.weeky_viewable_id')
            ->where('weeky_views.weeky_viewable_type', Media::class)
            ->whereDate('date', '>=', $firstDateOfWeek)
            ->whereDate('date', '<=', $lastDateOfWeek)
            ->orderBy('weeky_views.views', 'desc')->select('media.*')->take(50)->get();

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $items = $newData->slice(($currentPage - 1) * $size, $size)->all();

        $newData = new LengthAwarePaginator(array_values($items), $newData->count(), 10, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'pageName' => 'page'
        ]);

        $oldDataIds = $this->model->where('type', $params['type'])
            ->join('weeky_views', 'media.id', '=', 'weeky_views.weeky_viewable_id')
            ->where('weeky_views.weeky_viewable_type', Media::class)
            ->whereDate('date', '>=', $oldFirstDateOfWeek)
            ->whereDate('date', '<=', $oldLastDateOfWeek)
            ->orderBy('weeky_views.views', 'desc')->pluck('media.id')->all();

        foreach ($newData as $rank => $media) {
            $oldRank = array_search($media->id, $oldDataIds);
            $media->differentRank = $oldRank === false ? trans('admin.new') : $oldRank - $rank;
        }

        return $newData;
    }

    public function getMedia($id, $params = [])
    {
        $query = $this->model->newQuery();
        $query->where('status', 1);

        if (isset($params['type'])) {
            $query->where('type', $params['type']);
        }

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

        if (isset($params['with_count'])) {
            $query->withCount($params['with_count']);
        }

        return $query->findOrFail($id);
    }

    public function getMediaForPlaylist($id, $params = [])
    {
        $query = $this->model->newQuery();
        $id = array_wrap($id);

        if (isset($params['type'])) {
            $query->where('type', $params['type']);
        }

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

        if (isset($params['with_count'])) {
            $query->withCount($params['with_count']);
        }

        $media = $query->whereIn('id', $id)->get();

        if (count($id) == 1) {
            return $media;
        }

        $media = $media->groupBy('id');
        $result = [];

        foreach ($id as $id) {
            $result[] = $media[$id][0];
        }

        return $result;
    }

    public function getMediaInAlbum($albumId, $params = [])
    {
        $query = $this->model->newQuery();

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

        if (isset($params['with_count'])) {
            $query->withCount($params['with_count']);
        }

        return $query->where('album_id', $albumId)->get();
    }

    public function getMediaComment($mediaId, $size = 5)
    {
        return $this->model->findOrFail($mediaId)->comments()->where('reply_id', 0)->with(['user', 'replies.user'])->orderBy('created_at', 'desc')->paginate($size);
    }

    public function getMediaSuggest($params)
    {
        $query = $this->model->newQuery();
        $params['media_id'] = isset($params['media_id']) ? array_wrap($params['media_id']) : [];
        $query->with('user')->whereNotIn('id', $params['media_id']);

        if (isset($params['type'])) {
            $query->where('type', $params['type']);
        }

        $query->where(function ($query) use ($params) {
            if (!empty($params['artist'])) {
                $query->orWhere('user_id', $params['artist']);
            }

            if (!empty($params['kind'])) {
                $params['kind'] = array_wrap($params['kind']);
                $query->orWhereHas('kinds', function ($query) use ($params) {
                    $query->whereIn('kinds.id', $params['kind']);
                });
            }

            if (!empty($params['region'])) {
                $query->orWhere('region_id', $params['region']);
            }
        });

        return isset($params['size']) ? $query->paginate($params['size']) : $query->paginate(10);
    }

    public function upViewMedia($id)
    {
        $media = $this->model->findOrFail($id);
        $media->update([
            'views' => $media->views + 1
        ]);

        $firstDateOfWeek = Carbon::now()->startOfWeek();
        $lastDateOfWeek = Carbon::now()->endOfWeek();
        $weekyViewer = $media->weekyViews()
            ->whereDate('date', '>=', $firstDateOfWeek)
            ->whereDate('date', '<=', $lastDateOfWeek)->first();

        if ($weekyViewer) {
            $weekyViewer->update([
                'views' => $weekyViewer->views + 1
            ]);
        } else {
            $media->weekyViews()->create([
                'views' => 1,
                'date' => Carbon::now()
            ]);
        }

        return $media;
    }

    public function createMedia($data, $dataKinds = [], $dataTags = [])
    {
        $data['status'] = 3;

        if (Auth::user()->role_id == 3) {
            $data['status'] = 1;
        }

        $media = $this->model->create($data);

        if (count($dataKinds)) {
            $media->kinds()->attach($dataKinds);
        }

        if (count($dataTags)) {
            $media->tags()->attach($dataKinds);
        }
    }

    public function updateMedia($id, $data, $dataKinds = [], $dataTags = [])
    {
        $media = $this->model->findOrFail($id);
        $media->update($data);
        $media->kinds()->sync($dataKinds);
        $media->tags()->sync($dataTags);
    }

    public function deleteMedia($id)
    {
        $media = $this->model->findOrFail($id);
        $media->update(['status' => 4]);
    }

    public function like($data)
    {
        $media = $this->model->findOrFail($data['id']);
        $like = $media->likes()
            ->where('user_id', Auth::user()->id)
            ->first();

        if ($like) {
            $like->delete();
        } else {
            $media->likes()->create([
                'status' => 1,
                'user_id' => Auth::user()->id,
            ]);
        }

        return $this->model->withCount('likes')->findOrFail($data['id'])->likes_count;
    }

    public function comment($data)
    {
        $media = $this->model->findOrFail($data['id']);
        $media->comments()->create([
            'status' => 1,
            'user_id' => Auth::user()->id,
            'content' => $data['content'],
            'reply_id' => isset($data['reply_id']) ? $data['reply_id'] : 0
        ]);
    }

    public function report($data)
    {
        $media = $this->model->findOrFail($data['id']);
        $media->reports()->create([
            'status' => 1,
            'user_id' => Auth::user()->id,
            'content' => $data['content'],
        ]);
    }

    public function addFavouriteList($user, $id)
    {
        $media = $this->model->findOrFail($id);

        if (!$media) {
            throw new Exception("not found", 1);
        }

        $favourite = $user->favourites()->where('media_id', $id)->first();

        if (!$favourite) {
            $user->favourites()->create([
                'media_id' => $id
            ]);
        }
    }

    public function removeFavouriteList($user, $id)
    {
        $media = $this->model->findOrFail($id);

        if (!$media) {
            throw new Exception("not found", 1);
        }

        $favourite = $user->favourites()->where('media_id', $id)->first();

        if ($favourite) {
            $favourite->delete();
        }
    }

    public function getFavouriteList($user, $size)
    {
        $mediaIds = $user->favourites()->pluck('media_id')->all();

        return $this->model->whereIn('id', $mediaIds)->with('user')->paginate($size);
    }
}
