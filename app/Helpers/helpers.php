<?php

if (!function_exists('format_price')) {
    function format_price(float $price): string
    {
        return number_format($price, 3) . ' د.ك';
    }
}

if (!function_exists('asset_image')) {
    function asset_image(?string $path, string $default = 'images/default-product.svg'): string
    {
        return $path ? asset('storage/' . $path) : asset($default);
    }
}
