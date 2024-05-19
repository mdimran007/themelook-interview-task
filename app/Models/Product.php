<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_sku',
        'product_name',
        'product_unit',
        'product_unit_value',
        'selling_price',
        'purchase_price',
        'discount',
        'tax',
        'attribute',
        'product_image',
        'status',
    ];

    public function attributes(){
        return $this->hasMany(ProductAttribute::class,'product_id');
    }
    public static function generateSKU()
    {
        $prefix = 'PROD';
        $randomString = Str::upper(Str::random(6));
        $sku = $prefix . '-' . $randomString;
        while (self::where('product_sku', $sku)->exists()) {
            $randomString = Str::upper(Str::random(6));
            $sku = $prefix . '-' . $randomString;
        }
        return $sku;
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->sku)) {
                $model->product_sku = self::generateSKU();
            }
        });
    }

}
