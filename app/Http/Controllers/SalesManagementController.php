<?php

namespace App\Http\Controllers;

use App\Models\BusinessData;
use App\Models\CreditRate;
use App\Models\Customer;
use App\Models\DollarRate;
use App\Models\Iva;
use App\Models\MerchandiseHistory;
use App\Models\PaymentType;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetails;
use App\Models\Saving;
use Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use DB;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use LaravelLang\Locales\Concerns\About;
use PDOException;
use Ramsey\Uuid\Type\Integer;
use Session;

class SalesManagementController extends Controller
{
     public function customerSalesHistoryShow($numberI = "")
     {



          $sales = Sale::with([
               'paymentType' =>
                    function ($query) {
                         $query->select(
                              'payment_type_id',
                              'name'
                         );
                    },
          ])->whereHas(
                    'customer',
                    function ($query) {
                         $query->where('card', '31048726');
                    },
               )
               ->orderBy('created_at', 'desc')
               ->paginate(8);
          return view(
               'admin.operations.sales-management.customer-receipt-history.show-all'
               ,
               [
                    'sales' => $sales,
                    ''
               ]
          );
     }

     public function index()
     {
          $sales = Sale::with([
               'paymentType' =>
                    function ($query) {
                         $query->select(
                              'payment_type_id',
                              'name'
                         );
                    },
          ])->with(
                    'customer',
                    function ($query) {
                         $query;
                    },
               )
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
               ->orderBy('created_at', 'desc')
               ->paginate(8);


          $salesHistory = 'false';
          return view(
               'admin.operations.sales-management.general-history.show-all'
               ,
               [
                    'sales' => $sales,
                    'dateRange' => false,
                    'search' => $salesHistory
               ]
          );
     }

     public function saleSeeDetails($slug)
     {

          $sale = Sale::where('slug', $slug)
               ->with([
                    'customer' => function ($query) {
                         return $query;
                    }
               ])->with([
                         'user' => function ($query) {
                              return $query

                                   ->with([
                                        'employee' => function ($query) {
                                             $query;
                                        }
                                   ]);
                         }
                    ])
               ->first();



          $sale_details = SaleDetails::where('sale_id', $sale->sale_id)
               ->with([
                    'products' => function ($query) {
                         return $query->select('name', 'product_id');
                    }
               ])
               ->get();



          $payment_types = PaymentType::all();


          return view(
               'admin.operations.sales-management.general-history.show-more-details',
               [
                    'sale' => $sale,
                    "sale_details" => $sale_details,
                    'payment_types' => $payment_types
               ]
          );

     }
     public function create()
     {
          //Record customer sale
          $bs = DollarRate::select('in_bs')->first();
          $iva = Iva::select('iva')->first();
          $credit_rate = CreditRate::select('value')->first();
          $payment_types = PaymentType::all();
          $saving = Saving::first();
          return view(
               'admin.operations.sales-management.register',
               [
                    'iva' => $iva,
                    'bs' => $bs,
                    'credit_rate' => $credit_rate,
                    "payment_types" => $payment_types,
                    "saving" => $saving
               ]
          );
     }

     public function customerSalesHistory()
     {
          return view(
               'admin.operations.sales-management.customer-receipt-history.search'
          );
     }

     public function searchCurtomer(Request $request)
     {

          $customer = Customer::where('card', $request->supplier_id_search)->first();

          if ($customer) {
               return response($customer)->header('Content-type', 'aplication/json');
          } else {
               return response(['customer' => false])->header('Content-type', 'aplication/json');

          }
     }

     public function searchProduct(Request $request)
     {
          if ($request->name_product == "") {
               return response(['customer' => false])->header('Content-type', 'aplication/json');
          }
          $customer = Product::select(
               'name',
               'code',
               'product_id',
               'price_dollar',
               'sale_profit_percentage',
               'discount_only_dollar',
               'description',
               'state'
          )->where('state', 'Para la venta')
               ->whereLike('name', '%' . $request->name_product . '%')->get();


          if (!$customer->count() == 0) {
               return response($customer)->header('Content-type', 'aplication/json');
          } else {
               return response(['customer' => false])->header('Content-type', 'aplication/json');

          }
     }

     public function store(Request $request)
     {


          try {
               /**if ($request->cliente_id == null) {
                    // (ERROR 400)Error de base de datos :  No se puede proceder a la operacion debido a que la enviada al servico incompleta
                    return redirect()->back()->with('alert-danger', 'Error 400 (Solicitud incorrecta): No se pudo completar la operación porque el cliente no está seleccionado.');
               }

               if (!$request->has('name_1')) {
                    return redirect()->back()
                         ->with('alert-danger', 'Error 400 (Solicitud incorrecta): No se pudo completar la operación porque no se seleccionó ningún producto para la venta del cliente.');
               }
 */
               DB::beginTransaction();
               $register_sale = new Sale();



               $slug = converter_slug($request->numero_comprobante);
               $register_sale->slug = 'n-' . $slug;
               $register_sale->customer_id = $request->cliente_id;
               $register_sale->sale_code = $request->numero_comprobante;
               if ($request->switchCheckChecked ?? 'off' == 'on') {
                    $register_sale->payment_type_id = 4;
               } else {
                    $register_sale->payment_type_id = $request->metodo_pago;
               }
               $paso_one = str_replace('.', '', $request->total_a_pagar);
               $paso_one = str_replace(',', '.', $paso_one);
               $register_sale->total_price_dollars = floatval($paso_one);
               $register_sale->exchange_rate_bs = floatval(str_replace(',', '.', $request->bs));
               $register_sale->credit_rate = $request->tasa_credito_actual;
               $register_sale->tax_base = floatval(str_replace(',', '.', $request->base_imponible)) ?? 0.0;
               $register_sale->VAT = $request->iva_actual;//El numero que se tomo el cuenta para el iva;
               $register_sale->VAT_tax_dollars = floatval(str_replace(',', '.', $request->iva)); //Iva total de la cuenta;
               $register_sale->status = 'Completada';
               $register_sale->expiration_date = $request->fecha_vencimiento;
               $register_sale->remarks = $request->observaciones;
               $register_sale->user_id = Auth::user()->user_id;
               $register_sale->credit_tax_dollars = floatval(str_replace(',', '.', $request->tasa_credito));
               $register_sale->paid_only_dollars = $request->switchCheckChecked ?? 'off' == 'on' ? 1 : 0;
               $register_sale->savings = floatval(str_replace(',', '.', $request->ahorro));
               $register_sale->only_currencies = floatval(str_replace(',', '.', $request->solo_divisas));
               if ($request->switchCheckChecked ?? 'off' == 'on') {
                    $soloDivisasABs = $request->solo_divisas * $request->bs;
                    $register_sale->payment_established = floatval(str_replace(',', '.', $soloDivisasABs));
               } else {

                    $register_sale->payment_established = floatval($paso_one);
               }


               $register_sale->save();


               $itemNames = 0;




               $requestData = $request->except([
                    "_method",
                    "_token",
                    "base_imponible",
                    "iva",
                    "iva_actual",
                    "tasa_credito",
                    "total_a_pagar",
                    "bs",
                    "cliente_id",
                    "numero_comprobante",
                    "metodo_pago",
                    "fecha_vencimiento",
                    "observaciones",
                    "generar_comprobante_pdf",
                    "tasa_credito_actual",
                    "solo_divisas",
                    "precio_regular_divisas",
                    "ahorro",
                    "tasa_bcv",
                    "saving"
               ]);
               foreach ($requestData as $value) {
                    $itemNames++;
               }

               $numberOfItems = $itemNames / 6;
               $sum = 0;


               for ($i = 1; $i <= $numberOfItems; $i++) {
                    $productNameKey = 'name_' . $i;
                    $productQuantityKey = 'quantity_' . $i;
                    $productIdKey = 'id_' . $i;
                    $productUnitCostDollarsKey = 'sale_price_usd_' . $i;
                    $productDiscountKey = 'discount_' . $i;
                    $productTotalParcialUsdKey = 'total_parcial_usd_' . $i;
                    if (
                         isset($requestData[$productNameKey]) && isset($requestData[$productQuantityKey]) && isset($requestData[$productIdKey])

                    ) {
                         $productId = $requestData[$productIdKey];
                         $productAmount = $requestData[$productQuantityKey];
                         $productUnitCostDollars = $requestData[$productUnitCostDollarsKey];
                         $productDiscount = str_replace('%', '', $requestData[$productDiscountKey]);

                         $productTotalParcialUsd = $requestData[$productTotalParcialUsdKey];
                         $sum = $sum + $productAmount;
                         SaleDetails::create([
                              'sale_id' => $register_sale->sale_id,
                              'product_id' => $productId,
                              'quantity' => $productAmount,
                              'unit_cost_dollars' => floatval(str_replace(',', '.', $productUnitCostDollars)),
                              'subtotal_dollars' => floatval(str_replace(',', '.', $productTotalParcialUsd)),
                              'discount' => $productDiscount
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
               $client = Customer::where('customer_id', $request->cliente_id)->first();
               $msgClient = "";
               if ($client->gender_id == 1) {
                    $msgClient = 'el cliente llamado ' . $client->name . ' ' . $client->lastname;
               } else {
                    $msgClient = 'la clienta llamada ' . $client->name . ' ' . $client->lastname;
               }

               MerchandiseHistory::create([
                    'message' => '<b>Salida: </b> Egreso para venta de ' . $numberOfItems . ' ' . $singular_or_plural_product . ', sumando ' . $sum . ' ' . $singular_or_plural . ' en total por ' . $msgClient,
               ]);

               DB::commit();

               if ($request->generar_comprobante_pdf == 'Solo Generar Venta') {
                    return redirect('registrar-venta')->with("alert-success-sale", "¡Transacción de venta completada! Se ha registrado la transacción del cliente.");
               }

               return $this->salePdf($register_sale->sale_id);

               //Session::flash("alert-success-sale", "Recibo y Detalles de la Venta Descargados del cliente. ¡Operación completada!");

          } catch (QueryException $ex) {

               DB::rollBack();

               echo $ex->getMessage();

               // return redirect()->back()->with('alert-danger', 'Error de base de datos: No se pudo completar la operación. Por favor, inténtalo de nuevo o contacta al soporte (A la Ing.Yaneri Perdomo Barrios).');

          } catch (PDOException $ex) {

               DB::rollBack();

               \Log::error('PDOException al procesar entrada de mercancía: ' . $ex->getMessage(), ['trace' => $ex->getTraceAsString()]);

               return redirect()->back()->with('alert-danger', 'Error de conexión a la base de datos. Por favor, inténtalo de nuevo más tarde.');

          } catch (Exception $ex) {

               DB::rollBack();

               \Log::error('Excepción general al procesar entrada de mercancía: ' . $ex->getMessage(), ['trace' => $ex->getTraceAsString()]);

               echo $ex->getMessage();
               // redirect()->back()->with('alert-danger', 'Ocurrió un error inesperado. Por favor, inténtalo de nuevo.');
          }
     }

     public function salePdf($sale_id_)
     {



          $sale = Sale::where('sale_id', $sale_id_)->with([
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
          ])->
               first();


          $sale_id = $sale->sale_id;

          $fecha_actual = Date('Y-m-d');

          $fecha_vencimiento = $sale->expiration_date;

          /*
          if ($fecha_actual > $fecha_vencimiento) {
               $sale->expiration_date = null;
               $sale->save();
          }
          */
          $sale_details = SaleDetails::select('quantity', 'sale_id', 'product_id', 'subtotal_dollars', 'unit_cost_dollars', 'discount')
               ->with([
                    'products' => function ($query) {
                         $query->select('product_id', 'name', 'code');
                    }
               ])->where('sale_id', $sale_id_)->get();

          $thereIsADiscount = SaleDetails::select('quantity', 'sale_id', 'product_id', 'subtotal_dollars', 'unit_cost_dollars', 'discount')
               ->whereNot('discount', 0)
               ->where('sale_id', $sale_id_)->count();

          $sale = Sale::with([
               "customer" => function ($query) {
                    $query->select('customer_id', 'name', 'lastname', 'identity_card_id', 'card', 'phone', 'address')
                    ;
               }
          ])->where('sale_id', $sale_id)->first();

          $business_data = BusinessData::with([
               'identityCard' => function ($query) {
                    return $query->select('letter', 'identity_card_id');
               }
          ])->first();



          $business_data = array($business_data);


          $pdf = Pdf::loadView(
               "admin.operations.sales-management.sale-receipt",
               [
                    'business_data' => $business_data,
                    'sale' => $sale,
                    'sale_details' => $sale_details,
                    'thereIsADiscount' => $thereIsADiscount
               ]
          );

          //Session::flash("alert-success-sale", "Recibo y Detalles de la Venta Descargados del cliente. ¡Operación completada!");

          return $pdf->download('Recibo-de-' . $sale['customer']['name'] . '-' . $sale['customer']['lastname'] . '-' . Date('d-m-Y') . '.pdf');


     }

     public function salesDateRange($startYear, $startMonth, $startDay, $endYear, $endMonth, $endDay)
     {
          $startDate = "{$startYear}-{$startMonth}-{$startDay}";
          $endDate = "{$endYear}-{$endMonth}-{$endDay}";

          $sales = Sale::with([
               'paymentType' =>
                    function ($query) {
                         $query->select(
                              'payment_type_id',
                              'name'
                         );
                    },
          ])->with(
                    'customer',
                    function ($query) {
                         $query;
                    },
               )
               ->whereBetween('created_at', [$startDate, $endDate])
               ->orderBy('created_at', 'desc')
               ->paginate(8);

          $salesHistory = 'salesHistory';

          return view(
               'admin.operations.sales-management.general-history.show-all'
               ,
               [
                    'sales' => $sales,
                    'dateRange' => true,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'search' => $salesHistory
               ]
          );
     }
}
