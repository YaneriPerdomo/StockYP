<?php

namespace App\Http\Controllers;

use App\Http\Requests\SavingRequest;
use App\Models\Saving;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use DB;
use Auth;
use PDOException;

class SavingController extends Controller
{
    public function index()
    {
        $saving = Saving::select()->with([
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
        ])->first();



        return view(
            "admin.catalogs.master-data.saving.show",
            ["saving" => $saving]
        );
    }




    public function edit()
    {
        $saving = Saving::first();

        return view(
            'admin.catalogs.master-data.saving.edit',
            [
                'saving' => $saving
            ]
        );
    }

    public function update(SavingRequest $request)
    {



        DB::beginTransaction();
        // 2. Limpiar y convertir el string de entrada a un número flotante
        // Si el usuario ingresa "1,23" y quieres que sea 1.23
        $cleanedAmount = str_replace(',', '', $request->saving_amount_usd); // Eliminar separadores de miles si los hubiera
         $savingAmount = floatval($cleanedAmount); // Convertir a número flotante

        // O una forma más sencilla si siempre esperas un punto decimal y el navegador lo envía así:
        // $savingAmount = floatval($request->saving_amount_usd);

        // O aún mejor, si la validación ya te permite números (pero te falla por el formato):
        // $savingAmount = (float) $request->saving_amount_usd;


        // 3. Obtener la instancia del modelo Saving
        $saving = Saving::firstOrCreate([]);

        // 4. Asignar el valor NUMÉRICO al modelo
        $saving->value = $savingAmount; // Asignamos el float, no el string formateado

        $saving->user_id = Auth::user()->user_id;
        $saving->save();

        DB::commit();



        return redirect()->route('saving.edit')
            ->with('alert-success', '¡El monto de ahorro ha sido actualizado exitosamente!');



    }



}
