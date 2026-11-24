<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activity';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'world_id',
        'level_difficulty',
        'mark',
    ];
    public function world()
{
    return $this->belongsTo(World::class, 'world_id');
}
}