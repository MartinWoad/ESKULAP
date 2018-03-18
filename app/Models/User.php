<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public const ADMIN = 'admin';
    public const ORDYNATOR = 'ordynator';
    public const LEKARZ = 'lekarz';

    protected $table = 'users';
    protected $guarded = [];
    protected $primaryKey = 'id';
}
