<?php

function setActive($routeName)
{
    return request()->routeIs($routeName) ? 'active' : '';
}

function convertir_a_numero($value)
{
    return number_format($value, 2);
}
