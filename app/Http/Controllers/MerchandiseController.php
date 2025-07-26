<?php

namespace App\Http\Controllers;

use App\Models\DollarRate;
use App\Models\MerchandiseHistory;
use App\Models\Product;
use App\Models\ReturnMerchandise;
use App\Models\ReturnMerchandiseDetails;
use Auth;
use DB;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use PDOException;

class MerchandiseController extends Controller
{
    public function create()
    {
        $products = Product::select('name', 'product_id', 'code', 'price_dollar')->get();
        $dollar_rate = DollarRate::first();
        return view(
            "admin.operations.merchandise-management.return.create"
            ,
            ["products" => $products, 'dollar_rate' => $dollar_rate]
        );
    }

    public function store(Request $request)
    {

        if (!$request->id_1) {
            return redirect()->back()->with('alert-danger', 'Error 400 (Solicitud incorrecta): Parece que aún no has seleccionado ni el producto inicial del listado disponible.');
        }
        try {
            DB::beginTransaction();
            $itemNames = 0;
            $good = ReturnMerchandise::create([
                "description" => $request->note ?? null,
                'user_id' => Auth::user()->user_id,
            ]);
            DB::commit();

            $requestData = $request->except(["_method", "_token", "note"]);
            foreach ($requestData as $value) {
                $itemNames++;
            }

            $numberOfItems = $itemNames / 3;
            $sum = 0;
            for ($i = 1; $i <= $numberOfItems; $i++) {
                $productNameKey = 'name_' . $i;
                $productQuantityKey = 'quantity_' . $i;
                $productIdKey = 'id_' . $i;
                if (isset($requestData[$productNameKey]) && isset($requestData[$productQuantityKey]) && isset($requestData[$productIdKey])) {
                    $productId = $requestData[$productIdKey];
                    $productAmount = $requestData[$productQuantityKey];
                    $sum = $sum + $productAmount;
                    ReturnMerchandiseDetails::create([
                        'return_merchandise_id' => $good->return_merchandise_id,
                        'product_id' => $productId,
                        'amount' => $productAmount,
                    ]);

                    $productToUpdate = Product::where('product_id', $productId)->first();

                    $saleCountStock = $productToUpdate->stock_available;
                    if ($saleCountStock <= 0) {
                        DB::rollBack();
                        $nameProduct = $requestData[$productNameKey];
                        return redirect()->back()->with(
                            'alert-danger',
                            'Error 409 (Conflicto): No podemos procesar la operacion. El producto con la siguiente descripción "' . $nameProduct . '" no tiene suficiente stock disponible. '
                        );
                    }
                    if ($productToUpdate) {
                        $productToUpdate->stock_available -= $productAmount;
                        $productToUpdate->save();
                    } else {
                        DB::rollBack();
                        abort(404, "Producto con ID {$productId} no encontrado durante la actualización de stock");
                    }
                } else {
                    DB::rollBack();
                    abort(400, 'Error: Faltan datos para uno o más productos (Error por parte del cliente). Asegúrate de que todos los campos "name_", "quantity_" e "id_" estén presentes y correctos.');
                }
            }
            $singular_or_plural = $sum == 1 ? 'unidad' : 'unidades';
            $singular_or_plural_product = $numberOfItems == 1 ? 'tipo producto' : 'tipos productos';
            MerchandiseHistory::create([
                'message' => '<b>Salida: </b> Egreso  de ' . $numberOfItems . ' ' . $singular_or_plural_product . ', sumando ' . $sum . ' ' . $singular_or_plural . ' en total.',
                'return_merchandise_id' => $good->return_merchandise_id
            ]);

            DB::commit();


            return redirect('devolucion-de-mercancia')->with("alert-success", "Devolución de mercancía completada con éxito. El inventario ha sido ajustado correctamente.");

        } catch (QueryException $ex) {

            DB::rollBack();

            \Log::error('QueryException al procesar entrada de mercancía: ' . $ex->getMessage(), ['trace' => $ex->getTraceAsString()]);

            return redirect()->back()->with('alert-danger', 'Error de base de datos: No se pudo completar la operación. Por favor, inténtalo de nuevo.');

        } catch (PDOException $ex) {

            DB::rollBack();

            \Log::error('PDOException al procesar entrada de mercancía: ' . $ex->getMessage(), ['trace' => $ex->getTraceAsString()]);

            return redirect()->back()->with('alert-danger', 'Error de conexión a la base de datos. Por favor, inténtalo de nuevo más tarde.');

        } catch (Exception $ex) {

            DB::rollBack();

            \Log::error('Excepción general al procesar entrada de mercancía: ' . $ex->getMessage(), ['trace' => $ex->getTraceAsString()]);

            return redirect()->back()->with('alert-danger', 'Ocurrió un error inesperado. Por favor, inténtalo de nuevo.');
        }
    }
}
