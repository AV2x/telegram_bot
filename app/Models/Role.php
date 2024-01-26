<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name'];
    use HasFactory;
    public function permissions()
    {
        return $this->hasOne(Permission::class, 'role_id', 'id');
    }
    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}
