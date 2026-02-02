<?php

namespace Src\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasUuids, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'owner_id',
        'fantasy_name',
        'description',
        'slogan',
        'legal_name',
        'document',
        'email',
        'phone',
        'image',
        'image_banner',
        'primary_color',
        'secondary_color',
        'domain',
        'zip_code',
        'state',
        'city',
        'neighborhood',
        'street',
        'number',
        'complement',
        'is_active',
        'user_id_created',
        'user_id_updated',
        'user_id_deleted',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
    ];
}
