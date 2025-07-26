export function generarCadenaAleatoria(longitud) {
    let resultado = "";
    const caracteres =
        "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    const caracteresLongitud = caracteres.length;
    for (let i = 0; i < longitud; i++) {
        resultado += caracteres.charAt(
            Math.floor(Math.random() * caracteresLongitud)
        );
    }
    return resultado;
}
