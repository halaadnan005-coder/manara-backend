<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class World extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'is_active',
    ];
    public function activities()
{
    return $this->hasMany(Activity::class, 'world_id');
}
}