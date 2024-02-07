<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_name',
        'share_id',
        'JAN',
        'price',
        'expiration_date',
        'quantity',
        'user_id',
    ];
}
