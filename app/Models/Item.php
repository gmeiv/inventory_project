<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $primaryKey = 'serial_number';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'serial_number',
        'serial_image',
        'name',
        'stocks',
        'total_stocks',
        'location',
        'category' ,
        'description' ,
        'image1' ,
        'image2' ,
        'image3' ,
        'image4' ,
        'image5' ,
    ];
}
