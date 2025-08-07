<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'traccar_id',
        'name',
        'unique_id',
        'status',
        'last_update',
        'position_id',
        'group_id',
        'phone',
        'model',
        'contact',
        'category',
        'disabled',
        'expires_at',
        'attributes',
    ];

    protected $casts = [
        'traccar_id' => 'integer',
        'status' => 'string',
        'last_update' => 'datetime',
        'position_id' => 'integer',
        'group_id' => 'integer',
        'disabled' => 'boolean',
        'expires_at' => 'datetime',
        'attributes' => 'array',
    ];

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id', 'traccar_id');
    }
}