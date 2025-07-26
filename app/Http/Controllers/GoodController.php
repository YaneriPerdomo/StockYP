<?php

namespace App\Http\Controllers;

use App\Http\Requests\MerchandiseManagementRequest;
use App\Models\DollarRate;
use App\Models\Good;
use App\Models\MerchandiseHistory;
use App\Models\MerchandisesDetails;
use App\Models\Product;
use Auth;
use DB;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use PDOException;

class GoodController extends Controller
{
    public function create()
    {

        $products = Product::select('name', 'product_id', 'code', 'price_dollar')->get();
        $dollar_rate = DollarRate::first();
        return view(
            "admin.operations.merchandise-management.goods.create"
            ,
            ["products" => $products, 'dollar_rate' => $dollar_rate]
        );

    }
    public function store(MerchandiseManagementRequest $request)
    {
        if (!$request->id_1) {
                return redirect()->back()->with('alert-danger', 'Error 400 (Solicitud incorrecta): Parece que aún no has seleccionado ni el producto inicial del listado disponible.');
            }
        try {

            
            DB::beginTransaction();
            $itemNames = 0;
            $good = Good::create([
                "description" => $request->description,
                'user_id' => Auth::user()->user_id
            ]);


            $requestData = $request->except(["_method", "_token", "description"]);
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
                    MerchandisesDetails::create([
                        'good_id' => $good->good_id,
                        'product_id' => $productId,
                        'amount' => $productAmount,
                    ]);
                    $productToUpdate = Product::where('product_id', $productId)->first();
                    if ($productToUpdate) {
                        $productToUpdate->stock_available += $productAmount;
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
                'message' => '<b>Entrada: </b> Ingreso de ' . $numberOfItems . ' ' . $singular_or_plural_product . ', sumando ' . $sum . ' ' . $singular_or_plural . ' en total.',
                'good_id' => $good->good_id
            ]);


            DB::commit();
            return redirect('registrar-mercancia')->with("alert-success", "Mercancía registrada y stock actualizado exitosamente.");

        } catch (QueryException $ex) {

            DB::rollBack();

            \Log::error('QueryException al procesar entrada de mercancía: ' . $ex->getMessage(), ['trace' => $ex->getTraceAsString()]);

            return redirect()->back()->with('alert-danger', 'Error de base de datos: No se pudo completar la operación. Por favor, inténtalo de nuevo o contacta al soporte.');

        } catch (PDOException $ex) {

            DB::rollBack();

            \Log::error('PDOException al procesar entrada de mercancía: ' . $ex->getMessage(), ['trace' => $ex->getTraceAsString()]);

            return redirect()->back()->with('alert-danger', 'Error de conexión a la base de datos. Por favor, inténtalo de nuevo más tarde.');

        } catch (Exception $ex) {

            DB::rollBack();

            \Log::error('Excepción general al procesar entrada de mercancía: ' . $ex->getMessage(), ['trace' => $ex->getTraceAsString()]);

            return redirect()->back()->with('alert-danger', 'Ocurrió un error inesperado. Por favor, inténtalo de nuevo.');
        }




        /*
        $product = Product::where('product_id', $request->product_id)->first();

        $product->stock_available = $product->stock_available + $request->quantity;

        $product->save();

        return $product;
        */
    }

}
