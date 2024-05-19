<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderRequest;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\IncomeExpense;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Modules\Accountsmanagement\Models\TblPaymentSide;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()){
            $data = Order::all();

            return datatables($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->format('m-d-Y H:i:s');
                })
                ->editColumn('status', function ($data) {
                    if ($data->status == ORDER_STATUS_PENDING){
                        return "<p class='bg bg-warning p-1 text-center rounded-pill'>Pending</p>";
                    }elseif($data->status == ORDER_STATUS_APPROVED){
                        return "<p class='bg bg-success p-1 text-center rounded-pill'>Approved</p>";
                    }elseif($data->status == ORDER_STATUS_CANCEL){
                        return "<p class='bg bg-danger p-1 text-center rounded-pill'>Cancel</p>";
                    }
                })
                ->addColumn('action', function ($data) {
                    return '<div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">...</a>
                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(47px, 51px, 0px);">
                                    <a href="#"  class="dropdown-item payment-head-update">Edit</a>
                                    <a class="dropdown-item" href="#">Delete</a>
                                </div>
                            </div>';
                })
                ->rawColumns(['created_at','status','action'])
                ->make(true);
        }
        $data['orderActive'] = 'active';
        return view('admin.order.list', $data);
    }

    public function store(OrderRequest $request)
    {
        DB::beginTransaction();
        try {
            $subtotal = 0;
            $tax = 0;
            $orderItemArray = [];
            foreach ($request->product as $key => $product) {
                foreach ($request->product_qty as $key2 => $qty) {
                    if ($key == $key2) {
                        $getProductData = Product::find($product);
                        if (!is_null($getProductData)) {
                            $subtotal = $subtotal + ($getProductData->discount != null ? (($getProductData->selling_price - ($getProductData->selling_price * ($getProductData->discount / 100))) * $qty) : ($getProductData->selling_price * $qty));
                            $tax = $tax + ($getProductData->tax != null ? (($getProductData->selling_price - ($getProductData->selling_price * ($getProductData->tax / 100))) * $qty) : 0);
                            $orderItemArray[$key] = [
                                'product_id' => $getProductData->id,
                                'product_sku' => $getProductData->product_sku,
                                'product_name' => $getProductData->product_name,
                                'product_amount' => ($getProductData->discount != null ? (($getProductData->selling_price - ($getProductData->selling_price * ($getProductData->discount / 100))) * $qty) : ($getProductData->selling_price * $qty)),
                                'product_tax' => $tax,
                                'product_qty' => $qty,
                            ];
                        }
                        break;
                    }
                }
            }

            $orderObj = new Order();
            $orderObj->customer_name = 'Mr Demo' . rand(00, 99);
            $orderObj->customer_address = 'Demo Address';
            $orderObj->customer_phone = rand(00, 99);
            $orderObj->sub_total = round($subtotal);
            $orderObj->tax = round($tax);
            $orderObj->total = round($subtotal + $tax);
            $orderObj->save();

            $orderRandomId = 'ODR-' . sprintf('%06d', $orderObj->id);
            Order::where('id', $orderObj->id)->update(['order_id' => $orderRandomId]);

            foreach ($orderItemArray as $item) {
                $orderItemObj = new OrderItem();
                $orderItemObj->order_id = $orderObj->id;
                $orderItemObj->product_id = $item['product_id'];
                $orderItemObj->product_sku = $item['product_sku'];
                $orderItemObj->product_name = $item['product_name'];
                $orderItemObj->product_amount = $item['product_amount'];
                $orderItemObj->product_tax = $item['product_tax'];
                $orderItemObj->product_qty = $item['product_qty'];
                $orderItemObj->save();
            }

            DB::commit();
            return redirect()->back()->with('success', 'Order added successfully');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::info($exception->getMessage());
            return redirect()->back()->with('error', 'Sorry something went wrong!');

        }
    }
}
