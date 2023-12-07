<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'total',
        'profit',
        'hour',
        'product_id'
    ];

    public function product(){
        return $this->belongsTo(product::class);
    }
}
