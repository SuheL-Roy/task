@extends('merchant\master')
@section('title')
    {{ __('Product List') }}
@endsection
<style>
    #spinner {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 10px;
}
</style>
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
                                <li class="breadcrumb-item" aria-current="page">Product List</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-12">
                    <div class="p-3">
                        @foreach($shop_page as $store)
                        <div class="mb-4">
                            <h4 class="bg-primary text-white p-2">{{ $store->first()->stores_name }}</h4> {{-- Store Name --}}
                            
                            <div class="row">
                                @foreach($store->groupBy('category_id') as $category)
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <div class="border rounded p-3">
                                        <h5 class="fw-bold text-dark border-bottom pb-2">{{ $category->first()->categories_name }}</h5> {{-- Category Name --}}
                                        
                                        <ul class="list-unstyled">
                                            @foreach($category as $product)
                                            <li class="py-1">{{ $product->products_name }}</li> {{-- Product Name --}}
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
   
@endsection
