<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHasRoles extends Model
{
    use HasFactory;


    protected $guarded = [];
    protected $table = 'user_has_role';
    public $timestamps = false;

    public function roleable(){
        $this->morphTo();
    }

    public function roleName(){
        $this->belongsTo(Role::class,'role_id');
    }
}
