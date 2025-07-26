<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreditRateRequest;
use App\Models\CreditRate;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Response;


class CreditRateController extends Controller
{

    public function index()
    {

        $credit_rate = CreditRate::select('value', 'updated_at', 'user_id')
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
            'admin.catalogs.master-data.credit-rate-settings.show',
            ['credit_rate' => $credit_rate]
        );
    }

    public function edit()
    {

        $credit_rate = CreditRate::select('value')->first();

        return view(
            'admin.catalogs.master-data.credit-rate-settings.edit',
            ['credit_rate' => $credit_rate]
        );
    }

    public function update(CreditRateRequest $request)
    {
        $credit_rate = CreditRate::first();
        if (!$credit_rate) {
            abort(500, 'Registro no encontrado');
        }
        $credit_rate->value = $request->credit_rate;
        $credit_rate->user_id = \Auth::user()->user_id;
        $credit_rate->save();
        return redirect('configuration-de-la-tasa-de-credito')->with("alert-success", "El valor de la tasa de interés del crédito se ha actualizado correctamente.");


    }
}