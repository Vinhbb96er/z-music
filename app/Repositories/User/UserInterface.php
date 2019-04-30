<?php

namespace App\Repositories\User;

interface UserInterface
{
    public function search($params = []);

    public function getTopFollowArtist($params = []);
}
