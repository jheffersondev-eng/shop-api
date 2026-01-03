<?php

namespace Src\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'id',
        'product_id',
        'image',
    ];

    protected $casts = [
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
    ];
}
