<?php

namespace App\Http\Controllers;

use App\Models\BusinessData;
use App\Models\Sale;
use App\Models\SaleDetails;
use Barryvdh\DomPDF\Facade\Pdf;
use Date;
use DB;
use Illuminate\Http\Request;

class SaleReportController extends Controller
{
    public function index()
    {

        return view('admin.report.sales.form');
    }


    public function reportPDF(Request $request)
    {

        if (!isset($request->tipoGenerarPdf)) {
            return redirect('informe-ventas')->with([
                'alert-danger' => 'Error 400 (Solicitud incorrecta): No se pudo completar la operación porque la selección de tipo de informe: ninguno está seleccionado. '
            ]);
        }

        if (isset($request->day)) { //Hoy
            switch ($request->tipoGenerarPdf) {
                case 'generalSummary':
                    return $this->generalSummaryDay();
                    break;
                case 'tenProducts':
                    return $this->tenProductsDay();

                    break;
                default:
                    # code...
                    break;
            }
        }

        if ($request->start_date  == null || $request->end_date == null) {
            return redirect('informe-ventas')->with([
                'alert-danger' => 'Error 400 (Solicitud incorrecta): 
                No se pudo completar la operación. Esto puede deberse a que una o ambas fechas están ausentes (vacías) o a que el formato de las fechas ingresadas es incorrecto. 
                
                '
            ]);
        }


        switch ($request->tipoGenerarPdf) {
            case 'generalSummary':
                return $this->generalSummaryDateRange($request->start_date, $request->end_date);
                break;
            case 'tenProducts':
                return $this->tenProductsDateRange($request->start_date, $request->end_date);

                break;
            default:
                # code...
                break;
        }
    }

    public function tenProductsDateRange($start_date, $end_date)
    {
        $ben_products = SaleDetails::select('product_id', DB::raw('SUM(quantity) AS cantidad_total'))
            ->with([
                'products' => function ($query) {
                    return $query->select('code', 'name', 'product_id');
                }
            ])
            ->whereBetween('sales_details.created_at', [$start_date, $end_date])
            ->groupBy('product_id')
            ->orderBy('cantidad_total', 'desc')
            ->limit(10)->get();

        $business_data = BusinessData::
            with([
                'identityCard' => function ($query) {
                    return $query;
                }
            ])->
            first();


        $start_date_VZL = explode('-', $start_date);
        $start_date_VZL = $start_date_VZL[2] . '-' . $start_date_VZL[1] . '-' . $start_date_VZL[0];

        $end_date_VZL = explode('-', $end_date);
        $end_date_VZL = $end_date_VZL[2] . '-' . $end_date_VZL[1] . '-' . $end_date_VZL[0];
        $pdf = Pdf::loadView(
            "admin.report.sales.reportTenProducts",
            [
                'ben_products' => $ben_products,
                'business_data' => $business_data,
                'start_date_VZL' => $start_date_VZL,
                'end_date_VZL' => $end_date_VZL,
                'tenProductsDateRange' => true
            ]
        );

        return $pdf->download(filename: 'Los-10-productos-mas-vendidos-del-' . $start_date_VZL . '-al-' . $end_date_VZL . '.pdf');

    }

    public function tenProductsDay()
    {
        $date = Date('Y-m-d');

        $ben_products = SaleDetails::select('product_id', DB::raw('SUM(quantity) AS cantidad_total'))
            ->with([
                'products' => function ($query) {
                    return $query->select('code', 'name', 'product_id');
                }
            ])
            ->whereDate('created_at', $date)
            ->groupBy('product_id')
            ->orderBy('cantidad_total', 'desc')
            ->limit(10)->get();

        $business_data = BusinessData::
            with([
                'identityCard' => function ($query) {
                    return $query;
                }
            ])->
            first();

        $pdf = Pdf::loadView(
            "admin.report.sales.reportTenProducts",
            [
                'ben_products' => $ben_products,
                'business_data' => $business_data,
                'tenProductsDateRange' => false
            ]
        );

        return $pdf->download(filename: 'Los-10-productos-mas-vendidos-del-dia-de-hoy' . $date . '.pdf');

    }
    public function generalSummaryDateRange($start_date, $end_date)
    {

        $date = Date('Y-m-d');
        $customers_served = Sale::Select('customer_id')->distinct('customer_id')
            ->whereBetween('created_at', [$start_date, $end_date])->get();

        $sales_made = Sale::select(DB::raw('count(customer_id) as ventas_realizadas'))
            ->whereBetween('created_at', [$start_date, $end_date])->first();

        $total_sales = Sale::select(DB::raw('sum(total_amount_paid_bs) as Total_ventas'))
            ->whereBetween('created_at', [$start_date, $end_date])->first();

        $total_VAT = Sale::select(DB::raw('count(VAT_tax_dollars) as iva'))
            ->whereBetween('created_at', [$start_date, $end_date])->first();

        $impuestos = Sale::select(DB::raw('SUM(VAT_tax_dollars) as iva, SUM(credit_tax_dollars) as credito'))
            ->whereBetween('created_at', [$start_date, $end_date])->first();

        $breakdown_by_product = DB::table('sales_details')
            ->select(
                'products.name AS nombre',
                DB::raw('COUNT(products.product_id) AS "Cantidad"'),
                DB::raw('SUM(sales_details.subtotal_dollars) AS "Total"')
            )
            ->join('products', 'products.product_id', '=', 'sales_details.product_id')
            ->whereBetween('sales_details.created_at', [$start_date, $end_date])
            ->groupBy('sales_details.product_id')
            ->get();

        $business_data = BusinessData::
            with([
                'identityCard' => function ($query) {
                    return $query;
                }
            ])->
            first();

        $start_date_VZL = explode('-', $start_date);
        $start_date_VZL = $start_date_VZL[2] . '-' . $start_date_VZL[1] . '-' . $start_date_VZL[0];

        $end_date_VZL = explode('-', $end_date);
        $end_date_VZL = $end_date_VZL[2] . '-' . $end_date_VZL[1] . '-' . $end_date_VZL[0];

        $pdf = Pdf::loadView(
            "admin.report.sales.report",
            [
                'business_data' => $business_data,
                'customers_served' => $customers_served,
                'sales_made' => $sales_made,
                'total_sales' => $total_sales,
                'impuestos' => $impuestos,
                'breakdown_by_product' => $breakdown_by_product,
                'start_date_VZL' => $start_date_VZL,
                'end_date_VZL' => $end_date_VZL,
                'generalSummaryDateRange' => true
            ]
        );

        return $pdf->download('Resumen-general-del-' . $start_date_VZL . '-al-' . $end_date . '.pdf');


    }
    public function generalSummaryDay()
    {


        $date = Date('Y-m-d');
        $customers_served = Sale::Select('customer_id')->distinct('customer_id')
            ->whereDate('created_at', $date)->get();

        $sales_made = Sale::select(DB::raw('count(customer_id) as ventas_realizadas'))
            ->whereDate('created_at', $date)->first();

        $total_sales = Sale::select(DB::raw('sum(payment_established) as Total_ventas'))
            ->whereDate('created_at', $date)->first();

        $total_VAT = Sale::select(DB::raw('count(VAT_tax_dollars) as iva'))
            ->whereDate('created_at', $date)->first();

        $impuestos = Sale::select(DB::raw('SUM(VAT_tax_dollars) as iva, SUM(credit_tax_dollars) as credito'))
            ->whereDate('created_at', $date)->first();

        $amountCurrencyOnly = Sale::select('paid_only_dollars', DB::raw('count(paid_only_dollars) as soloDivisasCantidad'))
            ->whereDate('created_at', $date)
            ->where('paid_only_dollars', 1)
            ->groupBy('paid_only_dollars')
            
            ->first();

      
        $breakdown_by_product = DB::table('sales_details')
            ->select(
                'products.name AS nombre',
                DB::raw('COUNT(products.product_id) AS "Cantidad"'),
                DB::raw('SUM(sales_details.subtotal_dollars) AS "Total"')
            )
            ->join('products', 'products.product_id', '=', 'sales_details.product_id')
            ->whereDate('sales_details.created_at', $date)
            ->groupBy('sales_details.product_id')
            ->get();

        $business_data = BusinessData::
            with([
                'identityCard' => function ($query) {
                    return $query;
                }
            ])->
            first();

        $pdf = Pdf::loadView(
            "admin.report.sales.report",
            [
                'business_data' => $business_data,
                'customers_served' => $customers_served,
                'sales_made' => $sales_made,
                'total_sales' => $total_sales,
                'impuestos' => $impuestos,
                'breakdown_by_product' => $breakdown_by_product,
                'generalSummaryDateRange' => false,
                'amountCurrencyOnly' => $amountCurrencyOnly
            ]
        );

        return $pdf->download('Resumen-general-del-día-de-hoy' . $date . '.pdf');


    }
}
