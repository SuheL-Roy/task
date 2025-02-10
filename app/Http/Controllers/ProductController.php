<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    public function MerchantProductList()
    {

        $categories = Category::latest()->get();
        $stores = Store::latest()->get();

        $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->join('stores', 'products.store_id', '=', 'stores.id')
            ->select('products.*', 'categories.category_name as category_name', 'stores.store_name as store_name')
            ->orderBy('products.created_at', 'desc')
            ->get();



        return view('merchant.product.list', compact('categories', 'stores', 'products'));
    }

    public function MerchantProductAdd(Request $request)
    {

        Product::insert([
            'product_name' => $request->product_name,
            'category_id' => $request->category_id,
            'store_id' => $request->store_id,
            'merchant_id' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        return back()->with('success', 'Successfully Inserted');
    } // end method


    public function MerchantProductDestroy($id)
    {
        Product::find($id)->delete();
        return back()->with('success', 'Successfully Deleted');
    }

    public function shop_wise_category(Request $request)
    {
        $shop_id = $request->id;
        $categories = Category::where('store_id', $shop_id)->get();
        return response()->json($categories);
    }

    public function shop_wise_category_product(Request $request)
    {
        $shop_page = Store::join('categories', 'stores.id', '=', 'categories.store_id')
            ->join('products', 'categories.id', '=', 'products.category_id')
            ->select(
                'stores.id as store_id',
                'stores.store_name as stores_name',  // Fixed column name
                'categories.id as category_id',
                'categories.category_name as categories_name', // Fixed column name
                'products.id as product_id',
                'products.product_name as products_name' // Fixed column name
            )
            ->orderBy('stores.id')
            ->orderBy('categories.id')
            ->get()
            ->groupBy('store_id');
        return view('all_shop_list_and_product', compact('shop_page'));    
    }
}
