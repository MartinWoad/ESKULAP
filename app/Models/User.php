<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    const ADMIN = 'admin';
    const ORDYNATOR = 'ordynator';
    const LEKARZ = 'lekarz';

    protected $table = 'users';
    protected $guarded = [];
    protected $primaryKey = 'id';
}
