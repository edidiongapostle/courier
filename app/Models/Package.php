<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_id',
        'barcode',
        'weight',
        'length',
        'width',
        'height',
        'status',
        'eta',
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(PackageStatusLog::class);
    }
} 