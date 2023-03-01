<?php
if (! function_exists('toCLP')) {
    function toCLP($monto)
    {
        return numfmt_create('es_CL', NumberFormatter::CURRENCY)->formatCurrency($monto, 'CLP');
    }
}