import {
    dollarExchangeRate,
    ivaRate,
    paymentMethod,
    subTotalAllProducts,
    summaryCalculationSpan,
} from "../consts/consts.js";
import { summarySale } from "../functions/summarySale.js";

export function productQuantityUpdateSummary() {
    document.addEventListener("change", (e) => {
         if (e.target.matches("#quantity")) {
            const quantityInput = e.target;
            const dataNumber = quantityInput.getAttribute("data-number");

            const salePriceInput = document.querySelector(
                `[name="sale_price_usd_${dataNumber}"]`
            );
            const totalNetoInput = document.querySelector(
                `[name="total_parcial_usd_${dataNumber}"]`
            );
            const discountInput = document.querySelector(
                `[name="discount_${dataNumber}"]`
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
        }
    });
}
