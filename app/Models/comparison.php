<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comparison extends Model
{
    use HasFactory;
    protected $guarded = array('id');
    protected $primaryKey = 'favorite_id';

    public function scopeNameLike($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%');
    }

    
    // public function login_get()
    // {
    //     return $this->belongsTo(User::class,'userid','id');
    // }
    
}
