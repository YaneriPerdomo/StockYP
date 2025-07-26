<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusinessDataRequest;
use App\Models\BusinessData;
use App\Models\IdentityCard;
use Illuminate\Http\Request;

class BusinessDataController extends Controller
{
    public function index()
    {
        $business_data = BusinessData::select('name', 'address', 'phone', 'email', 'updated_at','identity_card_id', 'rif')->first();
        $rif = IdentityCard::get();
        return view('admin.catalogs.master-data.business-data.show',
         [
            'business_data' => $business_data,
            'rif' => $rif
            ]
        );
    }

    public function update(BusinessDataRequest $request)
    {
        $business_data = BusinessData::first();
        $business_data->identity_card_id = $request->identity_card_id;
        $business_data->name = $request->business_name;
        $business_data->rif = $request->rif;
        $business_data->phone = $request->phone;
        $business_data->email = $request->email;
        $business_data->address = $request->address;
        $business_data->save();
        return redirect('datos-del-negocio')->with("alert-success", "Los datos del negocio han actualizado correctamente.");
    }
}
