<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pallet extends Model
{
    protected $fillable = ['barcode','user_id','status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function boxes()
    {
        return $this->hasMany(Box::class);
    }
}
