<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_sku'];

    public function product()
    {
        return $this->hasOne(Product::class, 'sku', 'product_sku');
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (Auth::user()) {
                $model->user_id = Auth::user()->id;
            } //set user id
        });
    }
}
