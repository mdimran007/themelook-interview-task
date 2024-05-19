@extends('admin.layouts.app')
@push('title')
    {{__("Dashboard")}}
@endpush
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <h4 class="m-auto mt-lg-5 alert alert-default-success">Welcome your dashboard</h4>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('script')
    <script src="{{asset('admin/custom/product.js')}}"></script>
@endpush
