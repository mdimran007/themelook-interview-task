@extends('admin.layouts.app')
@push('title')
    {{__("Dashboard")}}
@endpush

@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content pb-4">
            <div class="container-fluid">
                <div class="row">
                    <h3 class="text-center py-2 w-100">POS System</h3>
                    <div class="col-md-8">
                        <div class="border p-3 bg-light rounded">
                            <h5 class="pb-2">Product Section</h5>
                            <div class="p-2">
                                <div class="row">
                                    @foreach($productList as $item)
                                        <div class="col-md-3 add-to-list" style="cursor: pointer;"
                                             data-tax="{{($item->tax != null? ($item->selling_price - ($item->selling_price * ($item->tax / 100))):0)}}"
                                             data-id="{{$item->id}}"
                                             data-discount="{{$item->discount}}"
                                             data-product_name="{{$item->product_name}}"
                                             data-product_img="{{getImage($item->product_image)}}"
                                             data-product_price="{{$item->discount != null? ($item->selling_price - ($item->selling_price * ($item->discount / 100))):$item->selling_price}}">
                                            <div class="card p-2">
                                                <div class="mx-auto">
                                                    <img src="{{getImage($item->product_image)}}" class="card-img-top"
                                                         alt="img">
                                                </div>
                                                <div class="card-body">
                                                    <span>{{$item->product_name}}</span>
                                                    <p class="card-text text-center">
                                                        <strong>${{$item->discount != null? ($item->selling_price - ($item->selling_price * ($item->discount / 100))):$item->selling_price}} </strong> @if($item->discount != null)
                                                            <del>${{$item->selling_price}}</del>@endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border p-3 bg-light rounded">
                            <h5 class="pb-2">Billing Section</h5>
                            <div class="card p-2">
                                <form method="post" action="{{route('admin.order.store')}}" enctype="multipart/form-data">
                                    @csrf
                                <table class="table table-hover border-bottom">
                                    <thead>
                                    <tr>
                                        <th class="border-top-0" scope="col">Item</th>
                                        <th class="border-top-0" scope="col">QTY</th>
                                        <th class="border-top-0" scope="col">Price</th>
                                        <th class="border-top-0" scope="col">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody">
                                    <tr>
                                        <td colspan="4" class="text-center">No Item Selected</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="p-1">
                                    <div class="d-flex justify-content-between">
                                        <p>Sub Total: </p>
                                        <span><span id="subTotal">00</span>$</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p>Tax: </p>
                                        <span><span id="taxValue">00</span>$</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p>Total: </p>
                                        <span><span id="total">00</span>$</span>
                                    </div>
                                    @if ($errors->any())
                                        <ul>{!! implode('', $errors->all('<li style="color:red">:message</li>')) !!}</ul>
                                    @endif
                                    @if(session()->has('success'))
                                        <div class="alert alert-success m-20">
                                            {{ session()->get('success') }}
                                        </div>
                                    @endif
                                    @if(session()->has('error'))
                                        <div class="alert alert-danger m-20">
                                            {{ session()->get('error') }}
                                        </div>
                                    @endif
                                    <button type="submit" class="btn btn-primary w-100">Place Order</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('script')
    <script src="{{asset('admin/custom/pos.js')}}"></script>
@endpush
