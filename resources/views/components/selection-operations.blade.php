<div class="selection-operations">
    <nav class="container-xl flex-full__justify-content-between text-white">
        <div>
            <div class="dropdown">
                <button class="button text-white dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Operaciones
                </button>
                <ul class="dropdown-menu dropdown-menu-dark">
                    @if (Auth::user()->rol_id == 1 || Auth::user()->rol_id == 2)
                        <li>
                            <h6 class="dropdown-header">Gestión de Mercancias</h6>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('good.create') }}">Registrar Mercancia</a></li>
                        <li><a class="dropdown-item" href="{{ route('return-merchandise.create') }}">Devolución de
                                Mercancía</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                    @endif
                    @if (Auth::user()->rol_id == 1 || Auth::user()->rol_id == 2 || Auth::user()->rol_id == 4 || Auth::user()->rol_id == 3)

                        <li>
                            <h6 class="dropdown-header">Gestión de Ventas</h6>
                        </li>
                    @endif
                    @if (Auth::user()->rol_id == 1 || Auth::user()->rol_id == 2  || Auth::user()->rol_id == 3)

                        <li><a class="dropdown-item" href="{{ route('register.create') }}">Registrar Venta</a></li>
                    @endif
                    @if (Auth::user()->rol_id == 1 || Auth::user()->rol_id == 2 || Auth::user()->rol_id == 4  || Auth::user()->rol_id == 3)

                        <li><a class="dropdown-item" href="{{ route('general-history-sale.index') }}">Historial de Ventas
                                General</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                    @endif
                    @if (Auth::user()->rol_id == 2 || Auth::user()->rol_id == 1 || Auth::user()->rol_id == 3)
                        <li>
                            <h6 class="dropdown-header">Gestión de Garantías</h6>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('warranty-sale.search-for-sale') }}">
                                Seguimiento de Ventas y Garantías
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                    @endif
                    <li>
                        <h6 class="dropdown-header">Gestión de Inventario</h6>
                    </li>
                    <li><a class="dropdown-item" href="{{ route('all-products-stock.index') }}">
                            <i class="fas fa-boxes"></i> Todos los Productos y Stock
                        </a></li>
                    @if (Auth::user()->rol_id == 1 || Auth::user()->rol_id == 2 || Auth::user()->rol_id == 4)
                        <li><a class="dropdown-item" href="{{ route('spurchase-history.index') }}">
                            <i class="fas fa-exchange-alt"></i> Historial de Movimientos
                        </a></li>
                    @endif
                </ul>
            </div>
        </div>
        <div>
            <div class="dropdown">
                <button class="button text-white dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Catálogo{{ Auth::user()->rol_id != 3 ? 's' : '' }}
                </button>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li>
                        <h6 class="dropdown-header">@if (Auth::user()->rol_id != 3)
                            Maestros Principales
                        @else
                            Maestro Principal
                        @endif</h6>
                    </li>

                    @if (Auth::user()->rol_id == 1)
                        <li><a class="dropdown-item" href="{{ route('business-data.index') }}">Datos de la empresa</a></li>
                        <li><a class="dropdown-item" href="{{ route('employee.index') }}">Empleados</a></li>
                    @endif
                    @if (Auth::user()->rol_id == 1 || Auth::user()->rol_id == 2 || Auth::user()->rol_id == 4)
                        <li><a class="dropdown-item" href="{{ route('supplier.index') }}">Proveedores</a></li>
                        <li><a class="dropdown-item" href="{{ route('product.index') }}">Productos</a></li>
                    @endif
                    @if (Auth::user()->rol_id == 1 || Auth::user()->rol_id == 3)
                        <li><a class="dropdown-item" href="{{ route('customer.index') }}">Clientes</a></li>
                    @endif
                    @if (Auth::user()->rol_id == 1 || Auth::user()->rol_id == 4)
                        <li><a class="dropdown-item" href="{{ route('dollar-rate.index') }}">Tasa de Cambio (USD/BS)</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('saving.index') }}">Oferta Especial de Ahorro</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('iva-configuration.index') }}">Configuración del IVA</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('credit-rate-settings.index') }}">Configuración de la
                                Tasa de Crédito</a></li>
                        
                    @endif
                    @if (Auth::user()->rol_id == 1 || Auth::user()->rol_id == 2)

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <h6 class="dropdown-header">Configuración de Catálogos</h6>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('category.index') }}">Categorías</a></li>
                        <li><a class="dropdown-item" href="{{ route('brand.index') }}">Marcas</a></li>
                        <li><a class="dropdown-item" href="{{ route('location.index') }}">Ubicaciones</a></li>

                    @endif
                </ul>
            </div>
        </div>
        @if (Auth::user()->rol_id != 3 )
            <div>
            <div class="dropdown">
                <button class="button text-white dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    @if (Auth::user()->rol_id != 2)
                        Informes
                    @else
                        Informe
                    @endif
                </button>
                <ul class="dropdown-menu dropdown-menu-dark">
                    @if (Auth::user()->rol_id != 2)
                        <li><a class="dropdown-item" href="{{ route('sale-report.index') }}">Informe de Ventas</a></li>
                    @endif
                    <li><a class="dropdown-item" href="{{ route('stock-reporte.index') }}">Informe de Stock</a></li>
                </ul>
            </div>
        </div>
        @endif
    </nav>
</div>