<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administrators extends Model
{
    public $table = 'administrators';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
