<div>
    <a href="@php
        if (Auth::user()->rol_id == 1) {
            echo $relativePath . 'bienvenido-a';
        } else {
            if (Auth::user()->gender_id == 1) {
                echo $relativePath . 'bienvenido';
            } else {
                echo $relativePath . 'bienvenida';
            }
        }
    @endphp" class="text-decoration-none text-white fs-4">
        StockYP
    </a>
</div>