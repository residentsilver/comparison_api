<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comparison extends Model
{
    use HasFactory;
    protected $guarded = array('id');
    protected $primaryKey = 'id';

    public function scopeNameLike($query, $search)
    {
        return $query->where('guests_name', 'like', '%' . $search . '%');
    }
    
}
