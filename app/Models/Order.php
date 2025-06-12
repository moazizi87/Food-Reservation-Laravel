<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'total_amount',
        'status',
        'payment_status',
        'reservation_date',
        'notes'
    ];

    protected $casts = [
        'reservation_date' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function foods()
    {
        return $this->belongsToMany(Food::class, 'order_items')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
}
