<?php

namespace Src\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'id',
        'owner_id',
        'name',
        'category_id',
        'unit_id',
        'barcode',
        'is_active',
        'price',
        'cost_price',
        'stock_quantity',
        'min_quantity',
        'user_id_created',
        'user_id_updated',
        'user_id_deleted',
    ];

    protected $casts = [
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
    ];
}
