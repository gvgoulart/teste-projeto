<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'tag_id',
    ];

    public function tag() {
        return $this->belongsTo('App\Models\Tag');
    }

    public function product() {
        return $this->belongsTo('App\Models\Product');
    }
}
