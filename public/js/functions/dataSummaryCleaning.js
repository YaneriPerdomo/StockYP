import { summaryCalculationSpan } from "../consts/consts.js";

export function dataSummaryCleaning() {
    let total_pay_summary = summaryCalculationSpan[7];
    let credit_interest_rate = summaryCalculationSpan[5];
    let VAT_summary = summaryCalculationSpan[3];
    let tax_base = summaryCalculationSpan[1];
    let totalToPayUSD = summaryCalculationSpan[9];
    let porcentajeDescuentoSoloDivisas = summaryCalculationSpan[11];
    let solodivisas = summaryCalculationSpan[13];

    total_pay_summary.innerHTML = '0,00';
    credit_interest_rate.innerHTML = '0,00';
    VAT_summary.innerHTML = '0,00';
    tax_base.innerHTML = '0,00';
    totalToPayUSD.innerHTML = '0,00';
    porcentajeDescuentoSoloDivisas.innerHTML = '0';
    solodivisas.innerHTML = '0';
}
