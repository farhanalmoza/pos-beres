<?php
namespace App\Helpers;

class GenerateCode
{
    public static function invoice() {
        $date = date('ymd');
        $getCodeStore = "INV";
        $kode = sprintf("%05s", 1);
        return $getCodeStore.$date.$kode;
    }
}