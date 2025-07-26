<?php

namespace App\Http\Controllers;

use App\Http\Requests\IvaRequest;
use App\Models\Iva;
use App\Models\IvaConfiguration;
use Auth;
use Illuminate\Http\Request;

class IvaController extends Controller
{
    public function index()
    {

        $iva = Iva::select('iva', 'updated_at' ,'user_id')
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
            ->first();

        
        return view(
            'admin.catalogs.master-data.iva-configuration.show',
            ['iva' => $iva]
        );
    }

    public function edit()
    {

        $iva = Iva::select('iva')

            ->first();

        return view(
            'admin.catalogs.master-data.iva-configuration.edit',
            ['iva' => $iva]
        );
    }

    public function update(IvaRequest $request)
    {
        $iva = Iva::first();

        $iva->iva = $request->iva;
        $iva->user_id = Auth::user()->user_id;
        $iva->save();
        return redirect('configuration-del-iva')->with("alert-success", "El valor del el impuesto sobre el valor añadido (IVA) se ha actualizado correctamente.");


    }
}
