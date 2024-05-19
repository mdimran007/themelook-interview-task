@extends('admin.layouts.app')
@push('title')
    {{__("Dashboard")}}
@endpush

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table display text-nowrap" id="orderListTable">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Order Id</th>
                                    <th>Customer Name</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <input type="hidden" value="{{route('admin.order.index')}}" id="order-list-route">
@endsection
@push('script')
    <script src="{{asset('admin/custom/order.js')}}"></script>
@endpush
