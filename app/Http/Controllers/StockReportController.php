<?php

namespace App\Http\Controllers;

use App\Models\DollarRate;
use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
class StockReportController extends Controller
{
    public function index()
    {
        return view("admin.report.stock.form");
    }

    public function reportPDF(Request $request)
    {
        $title = "";
        $state = false;
         $products = "";
        switch ($request->report_type) {

            case 'critico':
                $title = "Listado de Productos Críticos";
                $state = true;
                $products = Product::select(
                    'name',
                    'location_id',
                    "code",
                    "sale_profit_percentage",
                    "price_dollar",
                    "slug",
                    "stock_available",
                    "discount_only_dollar"
                )->whereBetween('stock_available', [1, 8])
                    ->with([
                        "location" => function ($query) {
                            $query->select('location_id', 'name');
                        }
                    ])->get();
                //With(el nombre del metodo del modelo);
                break;
            case 'agotado':
                $state = true;
                $title = "Listado de Productos Agotados";
                $products = Product::select(
                    'name',
                    'location_id',
                    "code",                    "sale_profit_percentage",

                    "price_dollar",
                    "slug",
                    "stock_available",
                    "discount_only_dollar"
                )->where('stock_available', '=', '0')
                    ->with([
                        "location" => function ($query) {
                            $query->select('location_id', 'name');
                        }
                    ])->get();
                //With(el nombre del metodo del modelo);
                break;
            case 'todo':
                $title = "Listado de Productos ";
                $products = Product::select(
                    'name',
                    'location_id',
                    "code",
                    "price_dollar",
                    "slug",
                    "sale_profit_percentage",
                    "stock_available",
                    "discount_only_dollar"
                )->with([
                            "location" => function ($query) {
                                $query->select('location_id', 'name');
                            }
                        ])->get();
                //With(el nombre del metodo del modelo);
                break;
            default:
                # code...
                break;
        }
        $bs = DollarRate::select('in_bs')->first();
        $pdf = Pdf::loadView(
            "admin.report.stock.report",
            ['products' => $products, 'bs' => $bs, "state" => $state, "title" => $title]
        );
        return $pdf->download('informe-de-stock.pdf');
    }
}
