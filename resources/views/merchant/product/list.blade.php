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
                <!-- [ sample-page ] start -->
                <div class="col-sm-12">
                    <div class="card table-card">
                        <div class="card-body">
                            <div class="text-end p-sm-4 pb-sm-2">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#exampleModalLive">Add Product</button>
                            </div>
                            <div id="exampleModalLive" class="modal fade" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLiveLabel">Add Product</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <form action="{{ route('merchant.product.add') }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="row">


                                                    <div class="col-lg-12 pb-2">
                                                        <select
                                                            class="form-select store_id @error('store_name') is-invalid @enderror"
                                                            name="store_id" required>
                                                            <option value="">Select Store.</option>
                                                            @foreach ($stores as $store)
                                                                <option value="{{ $store->id }}">
                                                                    {{ $store->store_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('store_name')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-12 pb-2">
                                                        {{-- <select
                                                            class="form-select @error('category_name') is-invalid @enderror"
                                                            id="category" name="category_id" required>
                                                            <option value="">Select Category</option>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}">
                                                                    {{ $category->category_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('category_name')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror --}}
                                                        <select
                                                            class="form-select @error('category_name') is-invalid @enderror"
                                                            id="category" name="category_id" required>
                                                            <option value="">Select Category</option>
                                                        </select>
                                                        <div id="spinner" style="display: none;">
                                                            <div class="spinner-border text-primary" role="status">
                                                                <span class="visually-hidden">Loading...</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 pb-2">
                                                        <input type="text" required
                                                            class="form-control mt-2  @error('product_name') is-invalid @enderror"
                                                            name="product_name" placeholder="Enter Product Name">
                                                        @error('product_name')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover tbl-product" id="pc-dt-simple">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product Name</th>
                                            <th>Category Name</th>
                                            <th>Store Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $product->product_name }}</td>
                                                <td>{{ $product->category_name }}</td>
                                                <td>{{ $product->store_name }}</td>
                                                <td>
                                                    <a href="{{ route('merchant.product.destroy', $product->id) }}"
                                                        class="btn btn-danger">
                                                        Delete
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ sample-page ] end -->
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- Load jQuery from CDN -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>



    <script>
        $(document).ready(function() {
            $('.store_id').on('change', function() {
                var storeId = $(this).val();

                if (storeId) {
                    $('#spinner').show(); // Show spinner before request

                    $.ajax({
                        type: "GET",
                        url: "{{ route('merchant.shop_wise_category') }}",
                        data: {
                            id: storeId
                        },
                        success: function(response) {
                            $('#spinner').hide(); // Hide spinner after response
                            console.log(response);

                            $('#category').empty().append(
                                '<option value="">Select Category</option>');

                            $.each(response, function(index, category) {
                                $('#category').append('<option value="' + category.id +
                                    '">' + category.category_name + '</option>');
                            });
                        },
                        error: function() {
                            $('#spinner').hide(); // Hide spinner on error
                            alert('Failed to load categories');
                        }
                    });
                } else {
                    $('#category').empty().append('<option value="">Select Category</option>');
                }
            });
        });
    </script>
@endsection
