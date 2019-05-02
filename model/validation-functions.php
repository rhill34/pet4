<?php


function validColor($color)
{
    global $f3;
    return in_array($color, $f3->get('colors'));
}

function validText( $string )
{
    return (!empty($string) && ctype_alpha($string));
}
function validQty($qty)
{
    return (!empty($qty) && is_numeric($qty) && $qty >= 1);
}