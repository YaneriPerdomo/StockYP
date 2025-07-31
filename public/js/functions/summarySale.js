import { creditRate } from "../consts/consts.js";
import { formatted } from "./formatted.js";

export function summarySale(
    dollarExchangeRate,
    ivaRate,
    salePriceInput,
    totalNetoInput,
    discountInput,
    quantityInput,
    subTotalAllProducts,
    summaryCalculationSpan,
    paymentMethod
) {
    let salePrice =
        parseFloat(
            salePriceInput.value.replace("USD:", "").replace(",", ".")
        ) ?? 0;
    let quantity = parseInt(quantityInput.value);
    let discountText = discountInput.value;

    if (isNaN(quantity) || quantity < 1) {
        alert(
            "La cantidad no puede ser un valor negativo o cero. Se establecerá en 1."
        );
        quantityInput.value = 1;
        quantity = 1;
    }

    if (isNaN(salePrice)) {
        console.error("Error: El precio de venta no es un número válido.");
        totalNetoInput.value = "0,00";
        return;
    }

    let totalNeto = salePrice * quantity;
    let finalPrice = totalNeto;

    if (discountText !== "0%") {
        const discountPercentage = parseFloat(discountText.replace("%", ""));
        if (!isNaN(discountPercentage)) {
            const discountAmount = totalNeto * (discountPercentage / 100);
            finalPrice = totalNeto - discountAmount;
        } else {
            console.warn("Advertencia: El formato del descuento no es válido.");
        }
    }

    let formattedPrice = formatted(finalPrice);
    totalNetoInput.value = formattedPrice;

    let totalUsdBeforeIva = 0;

    const totalNetoInputs = document.querySelectorAll("#total_parcial_usd");

    totalNetoInputs.forEach((inputElement) => {
        totalUsdBeforeIva += parseFloat(inputElement.value.replace(",", "."));
        console.info(inputElement.value.replace(",", "."));
    });

    let ivaUsd = totalUsdBeforeIva * ivaRate;

    let totalUsdWithIva = totalUsdBeforeIva + ivaUsd;

    const totalBsBeforeIva = totalUsdBeforeIva * dollarExchangeRate;

    let ivaBs = totalBsBeforeIva * ivaRate;

    const totalBsWithIva = totalBsBeforeIva + ivaBs;

    let total_pay_summary = summaryCalculationSpan[7];
    let credit_interest_rate = summaryCalculationSpan[5];

    let VAT_summary = summaryCalculationSpan[3];
    let tax_base = summaryCalculationSpan[1];
    let totalToPayUSD = summaryCalculationSpan[9];
    let tasaBCV = document.querySelector('[name="tasa_bcv"]');
    let porcentajeSoloDivisas = 125 * dollarExchangeRate; //Tasa bcv

    let $diferenciaTasa = dollarExchangeRate - 125;
    $diferenciaTasa = $diferenciaTasa.toFixed(2);
    let PorcentajeDescuento = ($diferenciaTasa / 100) * 100;
    console.info(PorcentajeDescuento);

    porcentajeSoloDivisas = porcentajeSoloDivisas.toString().slice(0, 2);
    let porcentajeDescuentoSoloDivisas = summaryCalculationSpan[11];
    let solodivisas = summaryCalculationSpan[13];
    let total_Bs;
    if (paymentMethod.value === "1") {
        let credit_interest_rate_usd = totalUsdBeforeIva * creditRate;
        totalUsdWithIva = totalUsdWithIva + credit_interest_rate_usd;
        let total_a_pagar = totalUsdWithIva * dollarExchangeRate;
        let credit_interest_rate_bs = ivaBs * creditRate;
        console.clear();
        console.info("tasa de interes de credito");
        total_Bs = total_a_pagar;
        credit_interest_rate.innerHTML = formatted(
            credit_interest_rate_usd * dollarExchangeRate
        );
    } else {
        credit_interest_rate.innerHTML = 0;
        total_Bs = totalBsWithIva;
    }
    let bs = 110 * dollarExchangeRate;

    let totalCurrencyOnly3 = (total_Bs * porcentajeSoloDivisas) / 100;

    let totalCurrencyOnly2 = total_Bs - totalCurrencyOnly3;

    console.info(
        total_Bs + " " + totalCurrencyOnly2 + " " + totalCurrencyOnly3
    );
    let totalCurrencyOnly = totalCurrencyOnly2 / dollarExchangeRate;
    console.info(totalUsdWithIva + " " + dollarExchangeRate);
    total_pay_summary.innerHTML = formatted(
        totalUsdWithIva * dollarExchangeRate
    );

    VAT_summary.innerHTML = formatted(ivaUsd * dollarExchangeRate);
    tax_base.innerHTML = formatted(totalUsdBeforeIva * dollarExchangeRate);
    totalToPayUSD.innerHTML = formatted(totalUsdWithIva);

    let summaryMSG = document.querySelector(".summary__msg");
    let SoloDivisas = totalUsdWithIva * tasaBCV.value;

    let montoDisminuirAhorro = document.querySelector('[name="saving"]');
    let porcentajeAhorro = formatted(
        (
            (montoDisminuirAhorro.value / (SoloDivisas / tasaBCV.value)) *
            100
        ).toFixed(2)
    );

    totalCurrencyOnly = formatted(
        (SoloDivisas / tasaBCV.value - montoDisminuirAhorro.value).toFixed(2)
    );
    porcentajeDescuentoSoloDivisas.innerHTML = porcentajeAhorro;
    console.info(summaryMSG);

    let precioRegular = totalUsdWithIva;
    summaryMSG.innerHTML = `
    ¡**Oferta especial**! Paga en Divisas por solo $${totalCurrencyOnly} y ahorra ${porcentajeAhorro}%.**
        <br>
        <small>(Precio regular: $${precioRegular})</small>
    `;
    solodivisas.innerHTML = formatted(totalCurrencyOnly);
    subTotalAllProducts.innerHTML = `
                    <i>USD: ${formatted(totalUsdWithIva)}</i>
                    <i>BS: ${formatted(total_Bs)}</i>
                `;
}
