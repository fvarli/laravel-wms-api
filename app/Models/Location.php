<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['code','description'];

    public function inventoryMovements()
    {
        return $this->hasMany(InventoryMovement::class);
    }
}
