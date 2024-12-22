<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
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

    public static function requestNumber() {
        $date = date('ymd');
        $storeId = sprintf("%03s", Auth::user()->store_id);
        $storeIdDate = $storeId . $date;
        $query = "SELECT MAX(SUBSTRING(request_number, 12, 5)) AS request_number FROM product_requests WHERE SUBSTRING(request_number, 3, 9) = $storeIdDate";
        $checkReqNumber = DB::select($query);
        $getCodeStore = "RN";
        $urutan = (int)$checkReqNumber[0]->request_number;
        $urutan++;
        $kode = sprintf("%05s", $urutan);
        return $getCodeStore.$storeId.$date.$kode;
    }
}