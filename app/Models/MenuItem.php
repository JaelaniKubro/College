<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $table = 'menu_items';

    protected $fillable = [
        'seller_id',
        'menu_name',
        'category',
        'price',
        'description',
        'image_path',
    ];

    protected $primaryKey = 'id';

    public $timestamps = true;
}
