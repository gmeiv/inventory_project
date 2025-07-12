<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    // Only these columns will be mass assignable
    protected $fillable = [
        'title',
        'date',
        'time',
        'description',
    ];
}
