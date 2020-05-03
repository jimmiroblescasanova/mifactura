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

function makeRoleBadge($role)
{
    switch ($role) {
        case 1:
            return '<span class="badge badge-success">Admin</span>';
        case 0:
            return '<span class="badge badge-info text-white">Usuario</span>';
        default:
            return 'Error';
    }
}
