<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $fillable = [
        'surname', 'middlename', 'firstname', 'department', 'position', 'employment_type', 'email', 'password'
    ];
}