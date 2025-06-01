<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    protected $fillable = ['box_id','location_id','movement_type','user_id'];

    public function box()
    {
        return $this->belongsTo(Box::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
