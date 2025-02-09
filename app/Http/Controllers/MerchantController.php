<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MerchantController extends Controller
{
    public function MerchantsDashboard()
    {
        return view('merchant.merchant_dashboard');
    } // end method

}
