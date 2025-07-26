<?php

namespace App\Http\Controllers;

use App\Models\DollarRate;
use Auth;
use Illuminate\Http\Request;

class DollarRateController extends Controller
{
   public function index()
   {
      $dollar_rate = DollarRate::select("in_bs", 'updated_at', 'user_id')
         ->with([
            'user' => function ($query) {
               return $query
                  ->with([
                     'rol' => function ($query) {
                        $query;
                     }
                  ])
                  ->with([
                     'employee' => function ($query) {
                        $query;
                     }
                  ]);
            }
         ])
         ->where("dollar_rate_id", 1)
         ->first();
      
     
      return view(
         'admin.catalogs.master-data.dollar-rate.show',
         compact('dollar_rate')
      );
   }

   public function edit()
   {
      $dollar_rate = DollarRate::select("in_bs", 'updated_at')
         ->where("dollar_rate_id", 1)
         ->first();
      return view(
         'admin.catalogs.master-data.dollar-rate.edit',
         compact('dollar_rate')
      );
   }

   public function update(Request $request)
   {
      /**
       Establacer la zona horario:
        date_default_timezone_set('America/Caracas');
       */



      $in_bs = str_replace('.', '', $request->in_bs);
      $in_bs = str_replace(',', '.', $in_bs);
      $update_dollar_date = DollarRate::where("dollar_rate_id", 1)
         ->first();
      $update_dollar_date->user_id = Auth::user()->user_id;
      $update_dollar_date->in_bs = $in_bs;
      $update_dollar_date->save();


      return redirect('tasa-de-dolar')
         ->with("alert-success", "Se ha actualizado el tipo de cambio del dólar a bolívar");

   }
}
