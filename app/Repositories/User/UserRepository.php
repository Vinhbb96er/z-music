<?php

namespace App\Repositories\User;

use App\Repositories\BaseRepository;
use App\Models\User;
use DB;

class UserRepository extends BaseRepository implements UserInterface
{
    public function getModel()
    {
        return User::class;
    }

    public function search($params = [])
    {
        $query = $this->model->newQuery();

        if (!empty($params['is_artist'])) {
            $query->where('role_id', config('setting.user.role.artist'));
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

    public function getTopFollowArtist($params = [])
    {
        $params['is_artist'] = true;
        $params['with_count'] = 'followers';
        $params['sort_field'] = 'followers_count';
        $params['sort_type'] = 'desc';

        return $this->search($params);
    }

    public function createUser($data)
    {
        if (!isset($data['name'])) {
            $data['name'] = explode('@', $data['email'])[0];
        }

        if (!isset($data['gender'])) {
            $data['gender'] = config('setting.user.gender.man');
        }

        if (!isset($data['role_id'])) {
            $data['role_id'] = config('setting.user.role.member');
        }

        if (!isset($data['status'])) {
            $data['status'] = config('setting.user.status.active');
        }

        return $this->model->create($data);
    }
}
