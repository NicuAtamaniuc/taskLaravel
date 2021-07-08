<?php

namespace App;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table = 'roles';

    public function user()
    {
        return $this->belongsToMany(User::class, 'role_users', 'id_rol', 'id_user')->withPivot('id_rol','id_user');
    }
}
