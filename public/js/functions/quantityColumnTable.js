export function quantityColumnTable(items) {
    let amount = 0;
    items.forEach((element) => {
        amount++;
    });
    return amount;
}