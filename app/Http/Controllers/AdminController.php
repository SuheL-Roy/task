<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function MerchantList()
    {

        $merchants = User::where('role', 'Merchant')->get();

        return view('admin_merchant.merchant_list', compact('merchants'));
    } // end method
}
