<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tracking_number',
        'status',
        'service_type',
        'total_weight',
        'price',
        'eta',
        'approved',
        // New fields
        'sender_name','sender_phone','sender_email','sender_country','sender_street','sender_city','sender_state','sender_postal_code',
        'receiver_name','receiver_phone','receiver_email','receiver_country','receiver_street','receiver_city','receiver_state','receiver_postal_code',
        'shipment_type','document_category','length','width','height','contents_description','declared_value','commodity_code',
        'insurance_enabled','insurance_value','insurance_cost',
    ];

    protected $casts = [
        'eta' => 'datetime',
        'approved' => 'boolean',
        'insurance_enabled' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(\App\Models\ShipmentStatusLog::class);
    }
} 