<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\DollarRate;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetails;
use App\Models\Supplier;
use DB;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ControlPanelController extends Controller
{
    public function index()
    {

        $total_categorys = Category::count();
        $total_clients = Customer::count();
        $total_products = Product::count();
        $total_rate = DollarRate::select('in_bs')->first();
        $total_sale = Sale::count();
        $total_stock = Product::select(DB::raw('SUM(stock_available) as current_stock'))->first();
        $total_supplier = Supplier::count();
        //Top 1 products 
        /*SELECT products.`name`, SUM(quantity) AS "Cantidad total" FROM sales_details 
            INNER JOIN products ON sales_details.product_id = products.product_id
            GROUP BY sales_details.product_id LIMIT 2;*/
        //ten best-selling products
        
        /*$ben_products = SaleDetails::select('product_id', DB::raw('SUM(quantity) AS cantidad_total'))
            ->with([
                'products' => function ($query) {
                    return $query->select('code', 'name', 'product_id');
                }
            ])->groupBy('product_id')
            ->orderBy('cantidad_total', 'desc')
            ->limit(10)->get();
        
        */
         return view(
            "admin.control-panel",
            [
                'total_categorys' => $total_categorys,
                'total_clients' => $total_clients,
                'total_products' => $total_products,
                'total_rate' => $total_rate->in_bs,
                'total_sale' => $total_sale,
                'total_supplier' => $total_supplier,
                'current_stock' => $total_stock->current_stock, 
            ]
        );
    }
}
