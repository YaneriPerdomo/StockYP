<?php

namespace App\Http\Controllers;

use App\Models\BusinessData;
use App\Models\Customer;
use App\Models\MerchandiseHistory;
use App\Models\PaymentType;
use App\Models\Product;
use App\Models\ReturnMerchandise;
use App\Models\ReturnMerchandiseDetails;
use App\Models\Sale;
use App\Models\SaleDetails;
use App\Models\SaleRepair;
use App\Models\WarrantyHistory;
use Barryvdh\DomPDF\Facade\Pdf;
use DB;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use PDOException;
use function PHPUnit\Framework\returnArgument;

class WarrantyManagementController extends Controller
{

    public function changeProductStatus(Request $request)
    {


        DB::beginTransaction();

        $itemNames = 0;

        $requestData = $request->except(['_token', '_method', 'sale_price_usd_1', 'discount_1', 'total_parcial_usd_1']);
        foreach ($requestData as $value) {
            $itemNames++;
        }

        $numberOfItems = $itemNames / 1;
        $sum = 0;

        for ($i = 1; $i <= $numberOfItems; $i++) {
            $productIdKey = 'id_' . $i;
            $warrantyStatusKey = 'warranty_status_' . $i;
            if (
                isset($requestData[$warrantyStatusKey]) && isset($requestData[$productIdKey])
            ) {
                $productId = $requestData[$productIdKey];
                $productWarrantyStatus = $requestData[$warrantyStatusKey];
                $updateSaleDetails = SaleDetails::where('sale_detail_id', $productId)->first();

                $updateSaleDetails->warranty_status = $productWarrantyStatus;
                $updateSaleDetails->save();


            }
        }



        DB::commit();



        return true;
    }
    public function index()
    {

        $sales = SaleDetails::select(
            "sale_detail_id",
            "sale_id",
        )
            ->whereHas(
                'sale',
                function ($query) {
                    $query->select(
                        'payment_type_id',
                        "sale_id",
                        "customer_id",
                        "total_price_dollars",
                        "status",
                        'sale_code',

                        "created_at",
                        "slug"
                    )->where('status', 'Garantía Pendiente')
                        ->with([
                            'paymentType' =>
                                function ($query) {
                                    $query->select(
                                        'payment_type_id',
                                        'name'
                                    );
                                },
                        ])
                        ->with([
                            'customer' =>
                                function ($query) {
                                    $query->select(
                                        'customer_id',
                                        'name',
                                        'lastname',
                                        'card'
                                    );
                                },
                        ]);
                }
            )->orderBy('created_at', 'desc')
            ->paginate(8);

        return view(
            'admin.operations.warranty-management.products-with-guarantees',
            [
                'sales' => $sales
            ]
        );
    }
    public function searchForSale()
    {
        return view('admin.operations.warranty-management.search-for-sale');
    }

    public function showSaleWarrantyStatus(Request $request)
    {
        $code_sale = $request->sale_code;

        if ($code_sale == "") {
            return back()->with([
                'alert-danger'
                =>
                    'El código de venta es obligatorio'
            ]);
        }

        $sale = Sale::where('sale_code', $code_sale)
            ->with([
                'customer' => function ($query) {
                    return $query;
                }
            ])
            ->first();


        if ($sale) {

            $fecha_actual = Date('Y-m-d');

            $fecha_vencimiento = $sale->expiration_date;

            if ($sale->expiration_date == null) {
                $msg = 'La venta solicitada existe, pero <b>NO CUENTA CON GARANTIA.</b> Te recomendamos revisar los detalles de la compra.';
                return view('admin.operations.warranty-management.expired-or-non-existent-warranty-msg', [
                    'msg' => $msg
                ]);
            }
            if ($fecha_actual > $fecha_vencimiento) {

                $msg = 'La venta solicitada existe, pero <b>LA GARANTÍA YA NO ES VÁLIDA</b> debido al tiempo otorgado. Si lo desea, <i>puede ampliar el periodo de garantía.</i> <a href="/ampliar-garantia-de-venta/' . $code_sale . '" class=""> <b>Aquí</b> </a>';
                return view('admin.operations.warranty-management.expired-or-non-existent-warranty-msg', [
                    'msg' => $msg
                ]);
            }

            $count = 0;
            $sale_details = SaleDetails::where('sale_id', $sale->sale_id)
                ->with([
                    'products' => function ($query) {
                        return $query->select('name', 'product_id');
                    }
                ])
                ->get();
            $payment_types = PaymentType::all();

            $warranty_history = WarrantyHistory::select('message', 'created_at', 'warranty_history_id')->where('sale_id', $sale->sale_id)->get();





            return view('admin.operations.warranty-management.show-sale', [
                'sale' => $sale,
                'count' => $count,
                'payment_types' => $payment_types,
                'sale_details' => $sale_details,
                'warranty_history' => $warranty_history
            ]);
        } else {
            $msg = 'No encontramos ninguna venta relacionada con el código que ingresaste. Asegúrate de escribirlo correctamente.';
            return view('admin.operations.warranty-management.expired-or-non-existent-warranty-msg', [
                'msg' => $msg
            ]);
        }
    }

    public function showSelectOption(Request $request)
    {


        return view(
            'admin.operations.warranty-management.select-option',
            ['code_sale' => $request->sale_code]
        );



    }


    public function inRepair(Request $request)
    {


        $sale = Sale::with([
            'paymentType' =>
                function ($query) {
                    $query->select(
                        'payment_type_id',
                        'name'
                    );
                },
        ])->with([
                    'customer' =>
                        function ($query) {
                            $query->select(
                                'customer_id',
                                'name',
                                'lastname',
                                'card'
                            );
                        },
                ])->where('sale_code', $request->sale_code)->first();

        $sale_repair_query = SaleRepair::where('sale_id', $sale->sale_id)->exists();

        $sale_repair = '';
        if ($sale_repair_query) {
            $sale_repair = SaleRepair::where('sale_id', $sale->sale_id)->first();
            $sale_repair->comments = $request->general_observations;
            $sale_repair->estimated_completion_date = $request->completion_date;
            $sale_repair->technical_manager = $request->technical_manager;
            $sale_repair->save();
        } else {
            $sale_repair = new SaleRepair;
            $sale_repair->sale_id = $sale->sale_id;
            $sale_repair->comments = $request->general_observations;
            $sale_repair->estimated_completion_date = $request->completion_date;
            $sale_repair->technical_manager = $request->technical_manager;
            $sale_repair->save();
        }


        /*
         $business_data = BusinessData::with([
            'identityCard' => function ($query) {
                return $query->select('letter', 'identity_card_id');
            }
        ])->first();
        $business_data = array($business_data);
        $pdf = Pdf::loadView(
            "admin.operations.warranty-management.selection-warranty-conditions.repair-report",
            [
                'business_data' => $business_data,
                'sale' => $sale,
                'sale_repair' => $sale_repair,
            ]
        );
        $pdfResponse = $pdf->download('Reporte-de-servicio-tecnico-de-' . $sale['customer']['name'] . '-' . $sale['customer']['lastname'] . '-' . Date('d-m-Y') . '.pdf');
        return $pdfResponse;
        */

        if ($request->technical_manager == "") {


            $warrantyHistory = new WarrantyHistory();
            $warrantyHistory->sale_id = $sale->sale_id;
            $warrantyHistory->message = "La venta con el '$request->sale_code' entró en estado de reparación.";
            $warrantyHistory->save();
        } else {

            $warrantyHistory = new WarrantyHistory();
            $warrantyHistory->sale_id = $sale->sale_id;
            $warrantyHistory->message = "La venta con código '$request->technical_manager' entró en estado de reparación.";
            $warrantyHistory->save();
        }

        return redirect('seguimiento-de-ventas-y-garantias/paso-1')->with(
            "alert-success",
            "Los producto(s) de la venta con código '$request->sale_code' se encuentra(n) en estado de reparación.
                    Para descargar el informe de servicio técnico, 
                        <a href='informe-servicio-tecnico/$sale->sale_id' class='text-black'>  haz clic aquí </a>"
        );

    }


    public function reportRepairPDF($sale_id)
    {

        $sale = Sale::with([
            'paymentType' =>
                function ($query) {
                    $query->select(
                        'payment_type_id',
                        'name'
                    );
                },
        ])->with([
                    'customer' =>
                        function ($query) {
                            return $query->select(
                                'customer_id',
                                'name',
                                'lastname',
                                'identity_card_id',
                                'card'
                            )->with([
                                        'identityCard' => function ($query) {
                                            $query->select('letter', 'identity_card_id');
                                        }
                                    ]);
                        },
                ])->where('sale_id', $sale_id)->first();

        $sale_repair = SaleRepair::where('sale_id', $sale_id)->first();

        $business_data = BusinessData::with([
            'identityCard' => function ($query) {
                return $query->select('letter', 'identity_card_id');
            }
        ])->first();

        $business_data = array($business_data);

        $pdf = Pdf::loadView(
            "admin.operations.warranty-management.selection-warranty-conditions.repair-report",
            [
                'business_data' => $business_data,
                'sale' => $sale,
                'sale_repair' => $sale_repair,
                ''
            ]
        );

        $pdfResponse = $pdf->download('Reporte-de-servicio-tecnico-de-' . $sale['customer']['name'] . '-' . $sale['customer']['lastname'] . '-' . Date('d-m-Y') . '.pdf');

        return $pdfResponse;
    }
    public function proceedWarranty(Request $request)
    {


        switch ($request->warranty_condition) {
            case 'in_repair':
                return view(
                    'admin.operations.warranty-management.selection-warranty-conditions.under-repair',
                    ['code_sale' => $request->sale_code]
                );
                break;
            case 'products_changed':
                //sale_code	
                /*   $sale_code = $request->sale_code ?? 0;
                   $products = SaleDetails::with([
                       'products' => function ($query) {
                           return $query;
                       }
                   ])->whereHas('sale', function (Builder $query, $sale_code = $sale_code) {
                       $query->where('sale_code', $sale_code);
                   })->get();

                   return $products;

                   */

                $sale = Sale::where('sale_code', $request->sale_code)->first();

                $products = SaleDetails::
                    select('quantity', 'product_id')
                    ->with([
                        'products' => function ($query) {
                            return $query->select('product_id', 'name', 'code');
                        }
                    ])->where('sale_id', $sale->sale_id)->
                    distinct()->
                    get();


                return view(
                    'admin.operations.warranty-management.selection-warranty-conditions.changed-products',
                    ['customer_id' => $sale->customer_id, 'products' => $products, 'sale_code' => $sale->sale_code]
                );

                break;
            default:
                # code...
                break;
        }
        return $request;
    }
    public function warrantyExtensionForm($code_sale)
    {

        $sale = $sale = Sale::select('expiration_date')
            ->where('sale_code', $code_sale)->first();

        return view('admin.operations.warranty-management.warranty-extension-form', [
            'code_sale' => $code_sale,
            'sale' => $sale
        ]);
    }

    public function warrantyExtensionFormPost(Request $request, $code_sale)
    {
        $sale = Sale::where('sale_code', $code_sale)->first();
        $sale->expiration_date = $request->expiration_date;
        $sale->save();

        return redirect('seguimiento-de-ventas-y-garantias/paso-1')->with("alert-success", "Se ha actualizado con éxito la garantía extendida para la venta $code_sale.");


        return 'proceso de garantia';
    }


    public function changedProducts(Request $request)
    {

        DB::beginTransaction();


        $itemNames = 0;
        $good = ReturnMerchandise::create([
            "description" => $request->description ?? null,
        ]);


        DB::commit();



        $requestData = $request->except(["_method", "_token", "description", "customer_id", "sale_code"]);
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
        $client = Customer::where('customer_id', $request->customer_id)->first();
        $msgClient = "";
        if ($client->gender_id == 1) {
            $msgClient = 'el cliente llamado ' . $client->name . ' ' . $client->lastname;
        } else {
            $msgClient = 'la clienta llamada ' . $client->name . ' ' . $client->lastname;
        }

        $change = $numberOfItems == 1 ? 'cambio' : 'cambios';

        MerchandiseHistory::create(attributes: [
            'return_merchandise_id' => $good->return_merchandise_id,
            'message' => '<b>Salida: </b> Egreso para ' . $change . ' de ' . $numberOfItems . ' ' . $singular_or_plural_product . ', sumando ' . $sum . ' ' . $singular_or_plural . ' en total por ' . $msgClient,
        ]);

        DB::commit();

        return redirect('seguimiento-de-ventas-y-garantias/paso-1')->with("alert-success", "Los productos de la venta con código '$request->sale_code' fueron reemplazados exitosamente, y el inventario se actualizó correctamente.");


    }
}
