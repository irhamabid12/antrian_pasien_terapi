<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductT extends Model
{
    use HasFactory;

    protected $table = 'product_t';
    protected $primaryKey = 'product_id';

    public $timestamps = false;
}
