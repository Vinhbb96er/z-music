<?php

namespace App\Repositories\Album;

use App\Repositories\BaseRepository;
use App\Models\Album;
use Auth;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class AlbumRepository extends BaseRepository implements AlbumInterface
{
    public function getModel()
    {
        return Album::class;
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        if (!empty($params['keyword'])) {
            $query->where(function($subQuery) use ($params) {
                $subQuery->orWhere('albums.name', 'like', '%' . $params['keyword'] . '%');
            });
        }

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

        if (!empty($params['first_artist'])) {
            $query->join('users', 'albums.user_id', '=', 'users.id')->orderBy('role_id', 'desc')->select('albums.*');
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
        $query = $this->model->newQuery();
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

        $newData = $query->join('weeky_views', 'albums.id', '=', 'weeky_views.weeky_viewable_id')
            ->where('weeky_views.weeky_viewable_type', Album::class)
            ->whereDate('date', '>=', $firstDateOfWeek)
            ->whereDate('date', '<=', $lastDateOfWeek)
            ->orderBy('weeky_views.views', 'desc')->select('albums.*')->take(50)->get();

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $items = $newData->slice(($currentPage - 1) * $size, $size)->all();

        $newData = new LengthAwarePaginator(array_values($items), $newData->count(), 10, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'pageName' => 'page'
        ]);

        $oldDataIds = $this->model
            ->join('weeky_views', 'albums.id', '=', 'weeky_views.weeky_viewable_id')
            ->where('weeky_views.weeky_viewable_type', Album::class)
            ->whereDate('date', '>=', $oldFirstDateOfWeek)
            ->whereDate('date', '<=', $oldLastDateOfWeek)
            ->orderBy('weeky_views.views', 'desc')->pluck('albums.id')->all();

        foreach ($newData as $rank => $album) {
            $oldRank = array_search($album->id, $oldDataIds);
            $album->differentRank = $oldRank === false ? trans('admin.new') : $oldRank - $rank;
        }

        return $newData;
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
                        $query->where('reply_id', 0)->where('status', 1)->with(['user', 'replies.user']);
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

    public function upViewAlbum($media, $albumsView = [])
    {
        $album = $media->album()->first();

        if (!$album || in_array($album->id, $albumsView)) {
            return false;
        }

        $album->update([
            'views' => $album->views + 1
        ]);

        $firstDateOfWeek = Carbon::now()->startOfWeek();
        $lastDateOfWeek = Carbon::now()->endOfWeek();
        $weekyViewer = $album->weekyViews()
            ->whereDate('date', '>=', $firstDateOfWeek)
            ->whereDate('date', '<=', $lastDateOfWeek)->first();

        if ($weekyViewer) {
            $weekyViewer->update([
                'views' => $weekyViewer->views + 1
            ]);
        } else {
            $album->weekyViews()->create([
                'views' => 1,
                'date' => Carbon::now()
            ]);
        }

        return $album;
    }

    public function getAlbumComment($mediaId, $size = 5)
    {
        return $this->model->findOrFail($mediaId)->comments()->where('reply_id', 0)->where('status', 1)->with(['user', 'replies.user'])->paginate($size);
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

    public function comment($data)
    {
        $album = $this->model->findOrFail($data['id']);
        $album->comments()->create([
            'status' => 1,
            'user_id' => Auth::user()->id,
            'content' => $data['content'],
            'reply_id' => isset($data['reply_id']) ? $data['reply_id'] : 0
        ]);
    }

    public function report($data)
    {
        $album = $this->model->findOrFail($data['id']);
        $album->reports()->create([
            'status' => 1,
            'user_id' => Auth::user()->id,
            'content' => $data['content'],
        ]);
    }
}
