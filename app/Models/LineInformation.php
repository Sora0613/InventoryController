<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LineInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'line_user_id',
        'line_user_name',
        'line_user_picture',
    ];

    public function getUserName()
    {
        return $this->line_user_name;
    }
}
