<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Good;
use App\Models\MerchandiseHistory;
use App\Models\MerchandisesDetails;
use App\Models\ReturnMerchandise;
use App\Models\ReturnMerchandiseDetails;
use Auth;
use DB;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;
use function PHPUnit\Framework\returnArgument;

class PurchaseHistoryController extends Controller
{
    public function index()
    {
        $purchase_history = MerchandiseHistory::select('good_id', 'created_at', 'message', 'return_merchandise_id', 'merchandise_history_id')
            ->orderBy('created_at', 'DESC')
            ->paginate(3);


        return view(
            'admin.operations.merchandise-management.goods.purchase-history'
            ,
            ['purchase_history' => $purchase_history]
        );
    }

    public function show($id, $statu)
    {

        switch ($statu) {
            case 'entrada':
                $type = 'entrada';
                $purchase_history = Good::select('good_id', 'description', 'created_at', 'user_id')
                    ->where('good_id', $id)
                    ->first();
                $responsible = '';
                if ($purchase_history->user_id == 1) {
                    $responsible = 'Administrador(a)';
                } else {
                    $responsible = Employee::select('user_id', 'name', 'lastname')
                        ->where('user_id', $purchase_history->user_id)
                        ->with([
                            'user' => function ($query) {
                                return $query->select('rol_id', 'user_id')
                                    ->with([
                                        'rol' => function ($query) {
                                            return $query;
                                        }
                                    ]);
                            }
                        ])
                        ->first();
                }
                $purchase_history2 = MerchandisesDetails::select('good_id', 'product_id', 'amount')
                    ->with([
                        'products' => function ($query) {
                            $query->select('product_id', 'name', 'code');
                        }
                    ])->where('good_id', $id)->paginate(10);
                $purchase_history = $purchase_history->toArray();

                return view(
                    'admin.operations.merchandise-management.goods.history-more-details'
                    ,
                    [
                        'type' => $type,
                        'responsible' => $responsible,
                        'purchase_history' => $purchase_history,
                        'purchase_history2' => $purchase_history2
                    ]
                );

                break;
            case 'salida':
                $type = 'salida';
                $purchase_history = ReturnMerchandise::select(
                    'return_merchandise_id',
                    'description',
                    'created_at',
                    'user_id'
                )
                    ->where('return_merchandise_id', $id)->first();

                $responsible = '';

                if ($purchase_history->user_id == 1) {
                    $responsible = 'Administrador(a)';

                } else {
                    $responsible = Employee::select('user_id', 'name', 'lastname')
                        ->where('user_id', $purchase_history->user_id)
                        ->with([
                            'user' => function ($query) {
                                return $query->select('rol_id', 'user_id')
                                    ->with([
                                        'rol' => function ($query) {
                                            return $query;
                                        }
                                    ]);
                            }
                        ])
                        ->first();
                }
                $purchase_history2 = ReturnMerchandiseDetails::select('return_merchandise_id', 'product_id', 'amount')
                    ->with([
                        'products' => function ($query) {
                            $query->select('product_id', 'name', 'code');
                        }
                    ])->where('return_merchandise_id', $id)->paginate(10);
                $purchase_history = $purchase_history->toArray();
                return view(
                    'admin.operations.merchandise-management.goods.history-more-details'
                    ,
                    [
                        'type' => $type,
                        'responsible' => $responsible,
                        'purchase_history' => $purchase_history,
                        'purchase_history2' => $purchase_history2
                    ]
                );
                break;

            default:
                # code...
                break;
        }

    }

    public function allDelete()
    {


        $history = DB::table('merchandise_history')->truncate();

        return redirect('historial-de-movimientos')->with(['alert-success' => 'Se eliminaron exitosamente todos los registros de entrada y salida del movimiento.']);


    }

    public function oneDelete($id)
    {
        $deletedHistory = MerchandiseHistory::where('merchandise_history_id', $id)->first();

        if (!$deletedHistory) {
            return redirect('historial-de-movimientos')
            ->with(['alert-danger' => '¡Registro no encontrado!']);

        }

        $deletedHistory->delete();

        return redirect('historial-de-movimientos')->with(['alert-success' => 'El registro de entrada y salida del movimiento seleccionado fue eliminado exitosamente.']);

    }
}
