<?php

function formatDate($date)
{
    return date('F j, Y, g:i a', strtotime($date));
}

function textShorten($text, $limit = 400)
{
    $text = $text . " ";
    $text = substr($text, 0, $limit);
    $text = substr($text, 0, strrpos($text, ' '));
    $text = $text . ".....";
    return $text;
}

function vndFormat($money)
{
    return number_format($money, 0, ',', '.') . ' VND';
}
