<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opname extends Model
{
    use HasFactory;
    protected $table = 'opname';
    protected $guarded = [];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
