@extends('merchant\master')
@section('title')
{{ __('Details') }}
@endsection
@section('content')

<div class="pc-container">

    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0)">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Details</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ sample-page ] start -->
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Shop Name : {{ $store->store_name }}</h5>
                    <div class="card-body">

                        @foreach ($categories as $category)
                        <h5 class="card-title"><b>Category Name :</b> {{ $loop->iteration }}.{{ $category->category_name }}</h5>
@php
    $category_id = $category->category_name;
    $products = App\Models\Product::where('category_name',$category_id)->where('store_name',$store->store_name)->get();
@endphp

                        @foreach ($products as $product)
                        <p class="card-text"><b>Product Name :</b> {{ $loop->iteration }}.{{ $product->product_name }}</p>
                        @endforeach

                        @endforeach
                    </div>
                </div>
            </div>
            <!-- [ sample-page ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>

@endsection
