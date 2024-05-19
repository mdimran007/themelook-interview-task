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

class PosController extends Controller
{
    public function index()
    {
        $data['posActive'] = 'active';
        $data['productList'] = Product::with(['attributes'])->paginate(10);
        return view('admin.pos.index', $data);
    }
}
