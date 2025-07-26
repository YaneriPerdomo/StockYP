import {
    dollarExchangeRate,
    ivaRate,
    paymentMethod,
    subTotalAllProducts,
    summaryCalculationSpan,
} from "../consts/consts.js";
import { quantityColumnTable } from "../functions/quantityColumnTable.js";
import { setIndexEachProduct } from "../functions/setIndexEachProduct.js";
import { summarySale } from "../functions/summarySale.js";

export function UpdatePaymentMethod() {
    paymentMethod.addEventListener("change", async (e) => {
        console.info("cambiando");
        let selectedProductColumns = document.querySelectorAll("#selected-product");

        let totalColumn = quantityColumnTable(selectedProductColumns);
 
        ///////////////////////////////////
        const salePriceInput = document.querySelector(
            `[name="sale_price_usd_${totalColumn}"]`
        );
        const totalNetoInput = document.querySelector(
            `[name="total_parcial_usd_${totalColumn}"]`
        );
        const discountInput = document.querySelector(
            `[name="discount_${totalColumn}"]`
        );
        const quantityInput = document.querySelector(
            `[name="quantity_${totalColumn}"]`
        );
        summarySale(
            dollarExchangeRate,
            ivaRate,
            salePriceInput,
            totalNetoInput,
            discountInput,
            quantityInput,
            subTotalAllProducts,
            summaryCalculationSpan,
            paymentMethod
        );
    });
}
