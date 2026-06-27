<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_name', 
        'total_price', 
        'status',
        'table_id' // Tambahkan ini untuk menyimpan info meja
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Tambahkan relasi ke Table
    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}