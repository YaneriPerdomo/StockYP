<?php

namespace App\Http\Controllers;

use App\Models\DollarRate;
use App\Models\Product;
use Illuminate\Http\Request;

class AllProductsStockController extends Controller
{
    public function index()
    {
        $products = Product::select(
            'name',
            'location_id',
            "sale_profit_percentage",
            "code",
            "discount_only_dollar",
            "price_dollar",
            "slug",
            "stock_available"
        )->

            with([
                "location" => function ($query) {
                    $query->select('location_id', 'name');
                }
            ])->paginate(8);
        //With(el nombre del metodo del modelo);

        $bs = DollarRate::select('in_bs')->first();


        return view(
            "admin.operations.inventory-management.all-products-stock-controller.show-all",
            ['products' => $products, 'bs' => $bs]
        );
    }
    
    public function search($productSearch )
    {
        $products = Product::select(
            'name',
            'location_id',
            "sale_profit_percentage",
            "code",
            "discount_only_dollar",
            "price_dollar",
            "slug",
            "stock_available"
        )->


            with([
                "location" => function ($query) {
                    $query->select('location_id', 'name');
                }
            ])
            ->whereLike('slug_name',  '%'.trim($productSearch ).'%')
            ->paginate(8);
        //With(el nombre del metodo del modelo);

        $bs = DollarRate::select('in_bs')->first();


        return view(
            "admin.operations.inventory-management.all-products-stock-controller.show-all",
            ['products' => $products, 'bs' => $bs, 'productSearch' => $productSearch ]
        );
    }

    public function edit($slug)
    {
        $product = Product::select('stock_available', 'slug')
            ->where('slug', $slug)->first();

        return view(
            "admin.operations.inventory-management.all-products-stock-controller.edit",
            ['product' => $product,]
        );
    }


}
