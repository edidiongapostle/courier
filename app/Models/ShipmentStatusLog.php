<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentStatusLog extends Model
{
    protected $fillable = [
        'shipment_id',
        'status',
        'changed_at',
        'updated_by',
        'note',
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
