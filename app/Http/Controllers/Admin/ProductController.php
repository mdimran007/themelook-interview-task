<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Product;
use App\Models\ProductAttribute;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function add()
    {
        $data['productActive'] = 'active';
        return view('admin.product.add', $data);
    }
    public function store(ProductRequest $request)
    {
        DB::beginTransaction();
        try {
            $productObj =  new Product();
            $productObj->product_name =  $request->product_name;
            $productObj->product_unit =  $request->product_unit;
            $productObj->product_unit_value =  $request->product_unit_value;
            $productObj->attribute =  (!empty($request->attribute))?json_encode($request->attribute):'';
            $productObj->selling_price =  $request->selling_price;
            $productObj->purchase_price =  $request->purchase_price;
            $productObj->discount =  $request->discount;
            $productObj->tax =  $request->tax;

            if ($request->hasFile('product_image')) {
                $file= $request->file('product_image');
                $uploadedPath = fileUpload($file, 'product');
                $productObj->product_image =  $uploadedPath;
            }
            $productObj->save();

            if (!empty($request->attribute)){
                foreach ($request->attribute as $attr){
                    if ($attr == 'size'){
                        foreach ($request->attribute_size as $item){
                            $attributeObj = new ProductAttribute();
                            $attributeObj->product_id = $productObj->id;
                            $attributeObj->product_sku = $productObj->product_sku;
                            $attributeObj->attributes_type = 'size';
                            $attributeObj->attributes_value = $item;
                            $attributeObj->save();
                        }
                    }
                    if ($attr == 'color'){
                        foreach ($request->attribute_color as $item){
                            $attributeObj = new ProductAttribute();
                            $attributeObj->product_id = $productObj->id;
                            $attributeObj->product_sku = $productObj->product_sku;
                            $attributeObj->attributes_type = 'color';
                            $attributeObj->attributes_value = $item;
                            $attributeObj->save();
                        }
                    }
                }
            }
            DB::commit();
            return redirect()->back()->with('success', 'Product added successfully');
        }catch (\Exception $exception){
          DB::rollBack();
            Log::info($exception->getMessage());
            return redirect()->back()->with('error', 'Sorry something went wrong!');

        }
    }
}
