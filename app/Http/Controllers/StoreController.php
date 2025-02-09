<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{

    public function MerchantStoreList()
    {
        $stores = Store::latest()->get();
        return view('merchant.store.list',compact('stores'));

    } // end method

    public function MerchantAddList(Request $request)
    {
        Store::insert([
            'store_name' => $request->store_name,
            'merchant_id' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        return back()->with('success','Successfully Inserted');

    } // end method


    public function MerchantStoreDestroy($id){

        Store::find($id)->delete();
        return back()->with('success','Successfully Deleted');

    } // end method


    public function MerchantStoreDetails($id){

        $store = Store::find($id);
        $userId = $store->merchant_id;
        $categories = Category::where('merchant_id',$userId)->get();
        return view('merchant.store.details',compact('store','categories'));

    } // end method




}
