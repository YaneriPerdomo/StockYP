export function setIndexEachProduct(inputs = []) {
    let sequentialIndex = 1;
    let InputNameTotal = inputs[6];
    let inputQuantity = inputs[0];
    let inputDiscount = inputs[1];
    let inputName = inputs[2];
    let inputId = inputs[3];
    let inputSalePrice = inputs[4];
    let inputTotalParcial = inputs[5];
    for (let i = 0; i <= InputNameTotal; i++) {
        if (!inputName[i]) {
            break;
        }
        
        inputQuantity[i].setAttribute("data-number", `${sequentialIndex}`);
        inputDiscount[i].setAttribute("name", `discount_${sequentialIndex}`);
        inputName[i].setAttribute("name", `name_${sequentialIndex}`);
        inputQuantity[i].setAttribute("name", `quantity_${sequentialIndex}`);
        inputId[i].setAttribute("name", `id_${sequentialIndex}`);
        inputSalePrice[i].setAttribute(
            "name",
            `sale_price_usd_${sequentialIndex}`
        );
        inputTotalParcial[i].setAttribute(
            "name",
            `total_parcial_usd_${sequentialIndex}`
        );
        sequentialIndex++;
    }
}
