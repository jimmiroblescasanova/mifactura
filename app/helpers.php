<?php

function setActive($routeName)
{
    return request()->routeIs($routeName) ? 'active' : '';
}

function convertir_a_numero($value)
{
    return number_format($value, 2);
}

function TipoDeImpuestos($impuesto)
{
    switch ($impuesto){
        case 001:
            return "ISR";
        case 002:
            return "IVA";
        case 003:
            return "IEPS";
        default:
            return "No se encontró";
    }
}
