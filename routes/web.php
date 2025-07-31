<?php

use App\Http\Controllers\AllProductsStockController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\BusinessDataController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConfigurationAdminController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\ControlPanelController;
use App\Http\Controllers\CreditRateController;
use App\Http\Controllers\CriticalStockController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerReceiptHistoryController;
use App\Http\Controllers\DollarRateController;
use App\Http\Controllers\EmployeeBookController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\GoodController;
use App\Http\Controllers\IvaController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MerchandiseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseHistoryController;
use App\Http\Controllers\SaleReportController;
use App\Http\Controllers\SalesManagementController;
use App\Http\Controllers\SavingController;
use App\Http\Controllers\StockReportController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\WarrantyManagementController;
use App\Models\CreditRate;
use Illuminate\Support\Facades\Route;

Route::controller(LoginController::class)->group(function () {
    Route::get('iniciar-sesion', 'index')->name('login');
    Route::post('iniciar-sesion', 'store')->name('attemptLogin');
    Route::post('cerrar-sesion', 'logout')->name('logout');
});

Route::get('bienvenida', [ControlPanelController::class, 'index'])
    ->middleware(['auth'])
    ->name('controlPanel.index-m');
Route::get('bienvenido', [ControlPanelController::class, 'index'])
    ->middleware(['auth'])
    ->name('controlPanel.index-f');
    Route::get('bienvenido-a', [ControlPanelController::class, 'index'])
    ->middleware(['auth'])
    ->name('controlPanel.index-f');

Route::controller(ConfigurationAdminController::class)->middleware(['auth'])->group(function () {
    Route::get('configuracion', 'index')->name('configuration.index');
    Route::put('configuracion', 'update')->name('configuration.update');
    Route::put('configuracion/cambiar-contrasena', 'updatePassword')->name('configuration.update-password');
});


Route::controller(CategoryController::class)->middleware(['auth'])->group(function () {
    Route::get('categorias', 'index')->name('category.index');
    Route::get('categoria/registrar', 'create')->name('category.create');
    Route::post('categoria/registrar', 'store')->name('category.store');
    Route::get('categoria/{slug}/editar', 'edit')->name('category.edit');
    Route::put('categoria/{slug}/editar', 'update')->name('category.update');
    Route::get('categoria/{slug}/eliminar', 'delete')->name('category.delete');
    Route::delete('categoria/{slug}/eliminar', 'destroy')->name('category.destroy');
});

Route::controller(BrandController::class)->middleware(['auth'])->group(function () {
    Route::get('marcas', 'index')->name('brand.index');
    Route::get('marca/registrar', 'create')->name('brand.create');
    Route::post('marca/registrar', 'store')->name('brand.store');
    Route::get('marca/{slug}/editar', 'edit')->name('brand.edit');
    Route::put('marca/{slug}/editar', 'update')->name('brand.update');
    Route::get('marca/{slug}/eliminar', 'delete')->name('brand.delete');
    Route::delete('marca/{slug}/eliminar', 'destroy')->name('brand.destroy');
});



Route::controller(LocationController::class)->middleware(['auth'])->group(function () {
    Route::get('ubicaciones', 'index')->name('location.index');
    Route::get('ubicacion/registrar', 'create')->name('location.create');
    Route::post('ubicacion/registrar', 'store')->name('location.store');
    Route::get('ubicacion/{slug}/editar', 'edit')->name('location.edit');
    Route::put('ubicacion/{slug}/editar', 'update')->name('location.update');
    Route::get('ubicacion/{slug}/eliminar', 'delete')->name('location.delete');
    Route::delete('ubicacion/{slug}/eliminar', 'destroy')->name('location.destroy');
});

Route::controller(SavingController::class)->middleware(['auth'])->group(function () {
    Route::get('oferta-especial-de-ahorro', 'index')->name('saving.index');
    Route::get('oferta-especial-de-ahorro/editar', 'edit')->name('saving.edit');
    Route::put('oferta-especial-de-ahorro/actualizar', 'update')->name('saving.update');
});

Route::controller(DollarRateController::class)->middleware(['auth'])->group(function () {
    Route::get('tasa-de-dolar', 'index')->name('dollar-rate.index');
    Route::get('tasa-de-dolar/editar', 'edit')->name('dollar-rate.edit');
    Route::put('tasa-de-dolar/editar', 'update')->name('dollar-rate.update');
});

Route::controller(SupplierController::class)->middleware(['auth'])->group(function () {
    Route::get('proveedores', 'index')->name('supplier.index');
    Route::get('proveedor/registrar', 'create')->name('supplier.create');
    Route::post('proveedor/registrar', 'store')->name('supplier.store');
    Route::put('proveedor/editar', 'update')->name('supplier.update');
    Route::get('proveedor/{slug}/editar', 'edit')->name('supplier.edit');
    Route::get('proveedora/{slug}/editar', 'edit')->name('supplier.edit');
    Route::put('proveedor/{slug}/editar', 'update')->name('supplier.update');
    Route::get('proveedor/{slug}/eliminar', 'delete')->name('supplier.delete-m');
    Route::get('proveedora/{slug}/eliminar', 'delete')->name('supplier.delete-f');
    Route::delete('proveedor/{slug}/eliminar', 'destroy')->name('supplier.destroy');

});

Route::controller(ProductController::class)->middleware(['auth'])->group(function () {
    Route::get('productos', 'index')->name('product.index');
    Route::post('productos', 'index')->name('product.index');
    Route::get('productos/{buscado}/buscar', 'search')->name('product.search');
    Route::get('producto/registrar', 'create')->name('product.create');
    Route::post('producto/registrar', 'store')->name('product.store');
    Route::get('producto/{slug}/editar', 'edit')->name('product.edit');
    Route::put('producto/{slug}/editar', 'update')->name('product.update');
    Route::get('producto/{slug}/eliminar', 'delete')->name('product.delete');
    Route::delete('producto/{slug}/eliminar', 'destroy')->name('product.destroy');
});

Route::controller(AllProductsStockController::class)->middleware(['auth'])->group(function () {
    Route::get('todos-los-productos-y-stock', 'index')->name('all-products-stock.index');
    Route::get('todos-los-productos-y-stock/{productSearch}/buscar', 'search')->name('all-products-stock.search');
    Route::get('todos-los-productos-y-stock/{slug}/editar-stock', 'edit')->name('all-product-stock.edit');
    Route::put('todos-los-productos-y-stock/{slug}/editar-stock', 'update')->name('all-product-stock.update');
});

Route::controller(CriticalStockController::class)->middleware(['auth'])->group(function () {
    Route::get('productos-con-stock-criticos', 'index')->name('critical-stock.index');
});
Route::controller(CriticalStockController::class)->middleware(['auth'])->group(function () {
    Route::get('productos-con-stock-criticos', 'index')->name('critical-stock.index');
});

Route::controller(StockReportController::class)->middleware(['auth'])->group(function () {
    Route::get('informe-stock', 'index')->name('stock-reporte.index');
    Route::post('informe-stock', 'reportPDF')->name('stock-report.reportPDF');
});

Route::controller(CustomerController::class)->middleware(['auth'])->group(function () {
    Route::get('clientes', 'index')->name('customer.index');
    Route::get('cliente/registrar', 'create')->name('customer.create');
    Route::post('clientes', 'store')->name('customer.store');
    Route::get('cliente/{slug}/editar', 'edit')->name('customer.edit');
    Route::get('clienta/{slug}/editar', 'edit')->name('customer.edit');
    Route::put('cliente/{slug}/editar', 'update')->name('customer.update');
    Route::get('cliente/{slug}/eliminar', 'delete')->name('customer.delete');
    Route::delete('cliente/{slug}/eliminar', 'destroy')->name('customer.destroy');
    Route::get('clienta/{slug}/eliminar', 'delete')->name('customer.delete');
});
Route::controller(EmployeeController::class)->middleware(['auth'])->group(function () {
    Route::get('empleados', 'index')->name('employee.index');
    Route::get('empleado/registrar', 'create')->name('employee.create');
    Route::post('empleados', 'store')->name('employee.store');
    Route::get('empleado/{slug}/editar', 'edit')->name('employee.edit');
    Route::get('empleada/{slug}/editar', 'edit')->name('employee.edit');
    Route::put('empleado/{slug}/editar', 'update')->name('employee.update');
    Route::get('empleada/{slug}/eliminar', 'delete')->name('employee.delete');
    Route::get('empleado/{slug}/eliminar', 'delete')->name('employee.delete');

});
Route::controller(GoodController::class)->middleware(['auth'])->group(function () {
    Route::get('mercancia', 'index')->name('good.index');
    Route::get('mercancia/registrar', 'create')->name('good.create');
    Route::post('mercancia/registrar', 'store')->name('good.store');
});

Route::controller(GoodController::class)->middleware(['auth'])->group(function () {
    Route::get('compras', 'index')->name('good.index');
    Route::get('registrar-mercancia', 'create')->name('good.create');
    Route::post('compra/registrar', 'store')->name('good.store');
});
Route::controller(MerchandiseController::class)->middleware(['auth'])->group(function () {
    Route::get('devolucion-de-mercancia', 'create')->name('return-merchandise.create');
    Route::post('mercancia/devolver', 'store')->name('return-merchandise.store');
});

Route::controller(SalesManagementController::class)->middleware(['auth'])->group(function () {
    Route::get('historial-de-ventas-general', 'index')->name('general-history-sale.index');
    Route::get('historial-de-ventas-general/del/{startYear}-{startMonth}-{startDay}-al/{endYear}-{endMonth}-{endDay}/buscar', 'salesDateRange')
        ->name('general-history-sale.sales-date-range');

    Route::get('registrar-venta', 'create')->name(name: 'register.create');
    Route::get('historial-ventas-general/{codeSale}/ver-detalles', 'saleSeeDetails')->name('sale.see-details');
    Route::post('venta-registrar', 'store')->name('register.store');
    Route::post('venta/buscar-cliente', 'searchCurtomer')->name('register.search-card');
    Route::post('venta/buscar-producto', 'searchProduct')->name('register.search-product');
    Route::post('venta/buscar-producto', 'searchProduct')->name('register.search-product');
    Route::post('venta/{codeSale}/pdf', 'salePdf')->name('sale.pdf');

});

Route::controller(PurchaseHistoryController::class)->middleware(['auth'])->group(function () {
    Route::get('historial-de-movimientos', 'index')->name('spurchase-history.index');
    Route::get('historial-de-movimientos/m-{id}/{statu}/mas-detalles', 'show')->name('spurchase-history.show');
    Route::delete('historial-de-movimientos/eliminar-todo', 'allDelete')->name('spurchase-history.all-delete');
    Route::delete('historial-de-movimientos/{id}/eliminar-uno', 'oneDelete')->name('spurchase-history.one-delete');

});

Route::controller(BusinessDataController::class)->middleware(['auth'])->group(function () {
    Route::get('datos-de-la-empresa', 'index')->name('business-data.index');
    Route::put('datos-de-la-empresa', 'update')->name('business-data.update');
});

Route::controller(IvaController::class)->middleware(['auth'])->group(function () {
    Route::get('configuration-del-iva', 'index')->name('iva-configuration.index');
    Route::get('configuration-del-iva/editar', 'edit')->name('iva-configuration.edit');
    Route::put('configuration-del-iva', 'update')->name('iva-configuration.update');
});

Route::controller(CreditRateController::class)->middleware(['auth'])->group(function () {
    Route::get('configuration-de-la-tasa-de-credito', 'index')->name('credit-rate-settings.index');
    Route::get('configuration-de-la-tasa-de-credito/editar', 'edit')->name('credit-rate-settings.edit');
    Route::put('configuration-de-la-tasa-de-credito', 'update')->name('credit-rate-settings.update');
});

Route::controller(CustomerReceiptHistoryController::class)->middleware(['auth'])->group(function () {
    Route::get('historial-de-ventas-garantia', 'index')->name('customer-receipt-history.index');
    Route::get('historial-de-ventas-garantia/{cedula}/mostrar', 'show')->name('customer-receipt-history.show');
});

Route::controller(WarrantyManagementController::class)->middleware(['auth'])->group(function () {
    Route::get('productos-con-garantias-valida', 'index')->name('customer-receipt-history.index');
    Route::get('seguimiento-de-ventas-y-garantias/paso-1', 'searchForSale')->name('warranty-sale.search-for-sale');
    Route::get('ampliar-garantia-de-venta/{code_sale}', 'warrantyExtensionForm')->name('warranty-sale.warranty-extesion-form');
    Route::post('ampliar-garantia-de-venta/{code_sale}', 'warrantyExtensionFormPost')->name('warranty-sale.warranty-extesion-form-post');
    Route::post('seguimiento-de-ventas-y-garantias/paso-3', 'showSelectOption')->name('warranty-sale.show-select-option');
    Route::post('seguimiento-de-ventas-y-garantias/paso-4', 'proceedWarranty')->name('warranty-sale.proceed-warranty');
    Route::post('seguimiento-de-ventas-y-garantias/paso-4/productos-cambiados', 'changedProducts')->name('warranty-sale.changed-products');

    // Cumplimiento de Garantía "En Reparación" 
    Route::post('seguimiento-de-ventas-y-garantias/paso-4/en_reparacion', 'inRepair')->name('warranty-sale.in-repair');

    //seguimiento-de-ventas-y-garantias/informe-servicio-tecnico/235
    Route::get('seguimiento-de-ventas-y-garantias/informe-servicio-tecnico/{sale_id}', 'reportRepairPDF')->name('warranty-sale.in-repair-pdf');

    Route::post('seguimiento-de-ventas-y-garantias/paso-2', 'showSaleWarrantyStatus')->name('warranty-sale.show-sale-warranty-status');
    //Proceed to the warranty
    //Route::post('seguimiento-de-ventas-y-garantias/paso-3', 'proceedWarranty')->name('warranty-sale.proceed-warranty');

});


Route::controller(SaleReportController::class)->middleware(['auth'])->group(function () {
    Route::get('informe-ventas', 'index')->name('sale-report.index');
    Route::post('informe-venta/day/pdf', 'reportPDF')->name('sale-report.dayReport');

});



