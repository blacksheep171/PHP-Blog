<?php
namespace App\Helpers;

class Helper {
    public static function clean($data) {
        return trim(htmlspecialchars($data, ENT_COMPAT, 'UTF-8'));
    }
    
    public static function cleanUrl($url) {
        return str_replace(['%20', ' '], '-', $url);
    }
}