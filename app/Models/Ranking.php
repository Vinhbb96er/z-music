<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
    protected $fillable = [
        'name', 
        'rankingable_id', 
        'rankingable_type', 
    ];

    public function rankingables()
    {
        return $this->morphMany();
    }
}
