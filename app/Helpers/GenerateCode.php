<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class GenerateCode
{
    public static function invoice() {
        $date = date('ymd');
        $query = "SELECT MAX(SUBSTRING(no_invoice, 10, 5)) AS no_invoice FROM transactions WHERE SUBSTRING(no_invoice, 4, 6) = $date";
        $checkInvoice = DB::select($query);
        $getCodeStore = "INV";
        $urutan = (int)$checkInvoice[0]->no_invoice;
        $urutan++;
        $kode = sprintf("%05s", $urutan);
        return $getCodeStore.$date.$kode;
    }

    public static function warehouseInvoice() {
        $date = date('ymd');
        $query = "SELECT MAX(SUBSTRING(no_invoice, 12, 5)) AS no_invoice FROM transactions WHERE SUBSTRING(no_invoice, 6, 6) = $date";
        $checkInvoice = DB::select($query);
        $getCodeStore = "INVGD";
        $urutan = (int)$checkInvoice[0]->no_invoice;
        $urutan++;
        $kode = sprintf("%05s", $urutan);
        return $getCodeStore.$date.$kode;
    }
}