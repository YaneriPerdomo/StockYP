<?php
if (!function_exists('converter_slug')) {
    function converter_slug($name_lastname, $cedula = '')
    {

        $text = Str::slug($name_lastname);

        if ($cedula != '') {
            $text .= '-' . $cedula;
        }

        return $text;
    }
}
use Carbon\Carbon;

if (!function_exists('formatting_hour')) {
    function formatting_hour($hour, $start)
    {
        $horaUtc = substr($hour, $start);

        // Crear un objeto Carbon a partir de la cadena de hora (asume una fecha arbitraria)
        $fechaHoraUtc = Carbon::parse($horaUtc, 'UTC'); // Asumimos que la hora original está en UTC

        // Convertir a la zona horaria local de Venezuela
        $fechaHoraLocal = $fechaHoraUtc->setTimezone('America/Caracas');

        // Formatear la hora al formato deseado (h:i a)
        $horaFormateada = $fechaHoraLocal->format('h:i a');

        return $horaFormateada;
    }
}
?>