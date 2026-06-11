<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageStatusLog extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'package_id',
        'status',
        'updated_by',
        'changed_at',
        'note',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
} 