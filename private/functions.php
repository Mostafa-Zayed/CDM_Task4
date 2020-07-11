<?php

function has_presence($value){
    return isset($value) && $value != '' & !empty($value);
}

function max_length($value,$max)
{
    return strlen($value) <= $max;
}

function min_length($value,$min)
{
    return strlen($value)  >= $min;
}

function has_in_array($vlaue,$set)
{
    return in_array($vlaue,$set);
}
function fillterData($value)
{
    $value = trim($value);
    $value = htmlspecialchars($value);
    $value = strip_tags($value);
    $value = filter_var($value,FILTER_SANITIZE_SPECIAL_CHARS);
    return $value;
}
