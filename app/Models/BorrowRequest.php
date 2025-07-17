<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'serial_number',
        'user_id',
        'status',
        'quantity',
        'borrow_until',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'serial_number', 'serial_number');
    }

    public function approvedByAdmin()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'approved_by_admin_id');
    }
    public function returnApprovedByAdmin() {
        return $this->belongsTo(Admin::class, 'return_approved_by_admin_id');
    }
}
