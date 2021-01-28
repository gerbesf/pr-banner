<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscrodHooks extends Model
{

    public $table = 'discord-hook';

    protected $fillable = [
        'server_id', 'endpoint', 'status', 'actual_map', 'timestamp'
    ];

    public $timestamps = false;
}

