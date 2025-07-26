<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\DollarRate;
use App\Models\Location;
use App\Models\Product;
use App\Models\Supplier;
use Auth;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use PDOException;

class ProductController extends Controller
{
    public function index()
    {


        $products = Product::select(
            'name',
            'category_id',
            "created_at",
            'brand_id',
            'location_id',
            "code",
            "price_dollar",
            "sale_profit_percentage",
            "discount_only_dollar",
            "description",
            "slug",
            "supplier_id",
            "state",
            "user_id",
        )->with([
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
            with([
                "category" => function ($query) {
                    $query->select('category_id', 'name')
                    ;
                }
            ])
            ->with([
                "supplier" => function ($query) {
                    $query->select('supplier_id', 'name')
                    ;
                }
            ])
            ->with([
                "brand" => function ($query) {
                    $query->select('brand_id', 'name');
                }
            ])
            ->with([
                "location" => function ($query) {
                    $query->select('location_id', 'name');
                }
            ])->paginate(8);
        //With(el nombre del metodo del modelo);

        $bs = DollarRate::select('in_bs')->first();




        return view(
            "admin.catalogs.master-data.products.show-all",
            ['products' => $products, 'bs' => $bs]
        );
    }

    public function search($buscado)
    {



        $products = Product::select(
            'name',
            'category_id',
            "created_at",
            'brand_id',
            'location_id',
            "code",
            "price_dollar",
            "sale_profit_percentage",
            "discount_only_dollar",
            "description",
            "slug",
            "supplier_id",
            "user_id",
            "state"
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
            ->
            with([
                "category" => function ($query) {
                    $query->select('category_id', 'name')
                    ;
                }
            ])
            ->with([
                "supplier" => function ($query) {
                    $query->select('supplier_id', 'name')
                    ;
                }
            ])
            ->with([
                "brand" => function ($query) {
                    $query->select('brand_id', 'name');
                }
            ])
            ->with([
                "location" => function ($query) {
                    $query->select('location_id', 'name');
                }
            ])
            ->whereLike('slug_name', '%' . trim($buscado) . '%')
            ->paginate(8);
        //With(el nombre del metodo del modelo);

        $bs = DollarRate::select('in_bs')->first();


        return view(
            "admin.catalogs.master-data.products.show-all",
            ['products' => $products, 'bs' => $bs, 'inputSearch' => $buscado]
        );
    }


    public function create()
    {

        $categorys = Category::select('category_id', 'name')->get();
        $brands = Brand::select('brand_id', 'name')->get();
        $locations = Location::select('location_id', 'name')->get();
        $suppliers = Supplier::select('supplier_id', 'name')
        ->where('state', 1)->get();
        return view(
            "admin.catalogs.master-data.products.create",
            [
                'categorys' => $categorys,
                'brands' => $brands,
                'locations' => $locations
                ,
                "suppliers" => $suppliers
            ]
        );
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        $product = new Product();
        $request->price_usd = str_replace(',', '', $request->price_usd);
        $slug_name = converter_slug($request->product_name);
        $slug = converter_slug($request->product_name, $request->sku);
        $product->slug = $slug;
        $product->user_id = Auth::user()->user_id;
        $product->slug_name = $slug_name;
        $product->name = $request->product_name;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->code = $request->sku;
        $product->supplier_id = $request->supplier_id;
        $product->location_id = $request->location_id;
        $product->description = $request->description;
        $product->price_dollar = $request->price_usd ?? 0.00;
        $product->created_at = Carbon::now();
        if (Auth::user()->rol_id == 2) {
            $product->state = 'Pendiente de precio';
        } else {
            if ($request->state == "1") {
                $product->state = 'En baja';
            } else {
                if ($product->sale_profit_percentage != '' || $product->sale_profit_percentage != '') {
                    $product->sale_profit_percentage = $request->profit_margin_percentage;
                    $product->discount_only_dollar = $request->discount_foreign_currency;
                    $product->state = 'Para la venta';
                } else {
                    return redirect('producto/registrar')->with([
                        'alert-danger' => 'No se pudo continuar la operación de actualización porque se debe ingresar un margen de beneficio.'
                    ]);
                }
            }
        }
        if ($product->sale_profit_percentage != '' || $product->sale_profit_percentage != '') {
            $product->sale_profit_percentage = $request->profit_margin_percentage;
            $product->discount_only_dollar = $request->discount_foreign_currency;
        }
        $product->save();
        DB::commit();
        return redirect('productos')->with("alert-success", "El producto ha sido registrado con éxito.");

    }

    public function edit($slug)
    {
        $product = Product::select(
            'name',
            'category_id',
            'brand_id',
            'location_id',
            "code",
            "supplier_id",
            "price_dollar",
            "sale_profit_percentage",
            "discount_only_dollar",
            "description",
            "slug",
            "state"
        )->where('slug', $slug)
            ->with([
                "category" => function ($query) {
                    $query->select('category_id', 'name')

                    ;
                }
            ])->with([
                    "supplier" => function ($query) {
                        $query->select('supplier_id', 'name')

                        ;
                    }
                ])
            ->with([
                "brand" => function ($query) {
                    $query->select('brand_id', 'name');
                }
            ])
            ->with([
                "location" => function ($query) {
                    $query->select('location_id', 'name');
                }
            ])->first();

        $categorys = Category::select('category_id', 'name')->get();
        $brands = Brand::select('brand_id', 'name')->get();
        $locations = Location::select('location_id', 'name')->get();
        $suppliers = Supplier::select('supplier_id', 'name')->get();
        if (!$product) {
            abort(404, 'No se pudo encontrar el registro');
        }



        return view('admin.catalogs.master-data.products.edit', [
            "categorys" => $categorys,
            "brands" => $brands,
            "locations" => $locations,
            "product" => $product,
            "suppliers" => $suppliers
        ]);
    }

    public function update(Request $request, $old_slug)
    {


        $request->price_usd = str_replace(',', '', $request->price_usd);




        DB::beginTransaction();
        $product = Product::where('slug', $old_slug)->first();
        $slug_name = converter_slug($request->product_name);
        $slug = converter_slug($request->product_name, $request->sku);
        $product->slug = $slug;
        $product->slug_name = $slug_name;
        $product->user_id = Auth::user()->user_id;
        $product->name = $request->product_name;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->code = $request->sku;
        $product->supplier_id = $request->supplier_id;
        $product->location_id = $request->location_id;

        if (Auth::user()->rol_id != 2) {
            if ($request->inactive_sale == "1") {
                $product->state = 'En baja';
            } else {
                if ($request->profit_margin_percentage != '') {
                    $product->sale_profit_percentage = $request->profit_margin_percentage;
                    $product->discount_only_dollar = $request->discount_foreign_currency ?? 0;
                    $product->state = 'Para la venta';
                } else {
                    return 'No se pudo continuar la operación de actualización porque se debe ingresar un margen de beneficio.';
                    return back()->withErrors([
                        'alert-danger' => 'No se pudo continuar la operación de actualización porque se debe ingresar un margen de beneficio.'
                    ]);
                }
            }
        }

        $product->description = $request->description;
        $product->price_dollar = $request->price_usd;
        $product->sale_profit_percentage = $request->profit_margin_percentage;
        $product->discount_only_dollar = $request->discount_foreign_currency;

        $product->save();
        DB::commit();

        return redirect('producto/' . $slug . '/editar')
            ->with("alert-success", "El producto ha sido actualizado con éxito.");

    }


    public function delete($slug)
    {
        $slug = Product::select('slug')->where('slug', $slug)->first();

        return view(
            "admin.catalogs.master-data.products.delete",
            ['slug' => $slug->slug]
        );
    }

    public function destroy($slug)
    {
        $deleted = Product::where('slug', $slug);
        $name = $deleted->name;
        $deleted->delete();
        return redirect('productos')
            ->with("alert-success", 'El producto "' . $name . '" ha sido eliminado' . " correctamente.");
    }
}
