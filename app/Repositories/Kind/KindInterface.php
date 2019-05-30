<?php

namespace App\Repositories\Kind;

interface KindInterface
{
    public function getTopViewkinds($size);

    public function getAll();
}
