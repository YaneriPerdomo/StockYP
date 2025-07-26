<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerReceiptHistoryController extends Controller
{
    public function index()
    {
        return view('admin.operations.sales-management.customer-receipt-history.search');
    }

    public function show($codigoRecibo){

        return $codigoRecibo;
        return view('admin.operations.warranty-management.search');
    }
}
