export function formatted(value) {
    return value.toLocaleString('es-ES', { style: 'decimal', minimumFractionDigits: 2, maximumFractionDigits: 2 })
        .toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
}

export function generateCostSale(cost_price, profit_margin, discount = 0, bs = 0, type, desc = false) {
    let porcentaje_ganancia_decimal = profit_margin / 100;
    let monto_ganancia_dolares = cost_price * porcentaje_ganancia_decimal;
    let precio_venta_inicial = cost_price + monto_ganancia_dolares;
    if (discount && desc == true) {
        let porcentaje_descuento_decimal = discount / 100;
        let monto_descuento_dolares = precio_venta_inicial * porcentaje_descuento_decimal;
        let precio_final_dolares_calculado = precio_venta_inicial - monto_descuento_dolares;
        let precio_final_dolares_formateado = formatted(precio_final_dolares_calculado);
        let precio_final_bolivares_calculado = precio_final_dolares_calculado * bs;
        let precio_final_bolivares_formateado = formatted(precio_final_bolivares_calculado);
        return type == 'USD' ? precio_final_dolares_formateado : precio_final_bolivares_formateado;
    } else {
        let precio_venta_dolares_formateado = formatted(precio_venta_inicial);
        let precio_venta_bolivares_calculado = precio_venta_inicial * bs;
        let precio_venta_bolivares_formateado = formatted(precio_venta_bolivares_calculado);
        return type == 'USD' ? precio_venta_dolares_formateado : precio_venta_bolivares_formateado;
    }
}