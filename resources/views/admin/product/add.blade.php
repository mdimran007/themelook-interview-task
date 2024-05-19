@extends('admin.layouts.app')
@push('title')
    {{__("Dashboard")}}
@endpush

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Add Product</h3>
                            </div>
                            @if ($errors->any())
                                <ul>{!! implode('', $errors->all('<li style="color:red">:message</li>')) !!}</ul>
                            @endif
                            @if(session()->has('success'))
                                <div class="alert alert-success m-20">
                                    {{ session()->get('success') }}
                                </div>
                            @endif
                        <!-- /.card-header -->
                            <!-- form start -->
                            <form method="POST" action="{{route('admin.product.store')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="product_name">Product Name</label>
                                        <input type="text" class="form-control" id="product_name"
                                               placeholder="Product Name" name="product_name">
                                        @error('product_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="product_unit">Product Unit</label>
                                        <input type="text" class="form-control" id="product_unit"
                                               placeholder="kg,litter,pieces" name="product_unit">
                                        @error('product_unit')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="product_unit_value">Product Unit Value</label>
                                        <input type="number" class="form-control" id="product_unit_value" min="1"
                                               placeholder="0" name="product_unit_value">
                                        @error('product_unit_value')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Attributes</label>
                                        <select class="select2 form-control product-attribute" multiple="multiple"
                                                name="attribute[]">
                                            <option>Select Attribute</option>
                                            <option value="size">Size</option>
                                            <option value="color">Color</option>
                                        </select>
                                    </div>

                                    <div class="form-group product-attribute-size">
                                        <label>Size</label>
                                        <div class="d-flex">
                                            <select class="select2 form-control" multiple="multiple"
                                                    name="attribute_size[]">
                                                <option>Select Size</option>
                                                @foreach(sizeList() as $key=>$size)
                                                    <option value="{{$key}}">{{$size}}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-danger ml-2 attribute-remove">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                        @error('attribute_size')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group product-attribute-color">
                                        <label>Color</label>
                                        <div class="d-flex">
                                            <select class="select2 form-control" multiple="multiple"
                                                    name="attribute_color[]">
                                                <option>Select Color</option>
                                                @foreach(colorList() as $key=>$color)
                                                    <option value="{{$key}}">{{$color}}</option>
                                                @endforeach
                                            </select>
                                            <button type="button" class="btn btn-danger ml-2 attribute-remove">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                        @error('attribute_color')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="selling_price">Selling Price</label>
                                        <input type="number" class="form-control" id="selling_price" min="1"
                                               placeholder="0" name="selling_price">
                                        @error('selling_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="purchase_price">Purchase Price</label>
                                        <input type="number" class="form-control" id="purchase_price" min="1"
                                               placeholder="0" name="purchase_price">
                                        @error('purchase_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="discount">Discount(%)</label>
                                        <input type="number" class="form-control" id="discount" min="1"
                                               placeholder="0" name="discount">
                                        @error('discount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="tax">Tax (%)</label>
                                        <input type="number" class="form-control" id="tax" min="1"
                                               placeholder="0" name="tax">
                                        @error('tax')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="product_image">Product image</label>
                                        <input type="file" class="form-control" id="product_image" name="product_image">
                                        @error('product_image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>


                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@push('script')
    <script src="{{asset('admin/custom/product.js')}}"></script>
@endpush
