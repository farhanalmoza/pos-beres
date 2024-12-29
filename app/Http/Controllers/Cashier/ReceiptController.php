<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Member;
use App\Models\Store;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Svg\Gradient\Stop;

class ReceiptController extends Controller
{
    public function testPrintReceipt() {
        try {
            $profile = CapabilityProfile::load("simple");
            $connector = new WindowsPrintConnector('RP58-Printer');

            $printer = new Printer($connector, $profile);

            $printer->text('================================');

            $printer->feed(3);
            $printer->cut();
            $printer->close();

            return response()->json(['success' => true, 'message' => 'Printing Successful']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function printReceipt($invoice) {
        $store = Store::find(Auth::user()->store_id);
        $transaction = Transaction::where('no_invoice', $invoice)->first();
        $cashier = User::find($transaction->created_by);
        $items = Cart::with('product', 'store')
            ->where('no_invoice', $invoice)
            ->where('store_id', $store->id)
            ->get();
            
        $memberName = "-";
        if ($transaction->member_id !== 0) {
            $member = Member::find($transaction->member_id);
            $memberName = $member->name;
        }

        try {
            $profile = CapabilityProfile::load("simple");
            $connector = new WindowsPrintConnector('RP58-Printer');

            $printer = new Printer($connector, $profile);

            // Store Information
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text(substr($store->name, 0, 32)."\n");
            $printer->text(substr($store->address, 0, 32)."\n");
            $printer->feed();

            // Transaction Information
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("================================\n");
            $printer->text($invoice);
            $printer->text(str_pad("Kasir: ". substr($cashier->name, 0, 8), 15, ' ', STR_PAD_LEFT) . "\n");
            $printer->text("Member: ". substr($memberName, 0, 15) . "\n");
            $printer->text("================================\n");

            // Items
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            foreach ($items as $item) {
                $printer->text(str_pad(substr($item->product->name, 0, 14), 15, ' ', STR_PAD_RIGHT));
                $printer->text(str_pad($item->quantity, 4, ' ', STR_PAD_LEFT));
                $printer->text(str_pad(number_format($item->price), 7, ' ', STR_PAD_LEFT));
                $printer->text(str_pad(number_format($item->price * $item->quantity), 6, ' ', STR_PAD_LEFT)."\n");
            }

            // Footer
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("--------------------------------\n");
            $printer->text("Subtotal". str_pad(number_format($transaction->total_item), 24, ' ', STR_PAD_LEFT) . "\n");
            $printer->text("Diskon". str_pad(number_format($transaction->transaction_discount), 26, ' ', STR_PAD_LEFT) . "\n");
            $printer->text("PPN". str_pad(number_format($transaction->ppn), 29, ' ', STR_PAD_LEFT) . "\n");
            $printer->text("Total Belanja". str_pad(number_format($transaction->total), 19, ' ', STR_PAD_LEFT) . "\n");
            $printer->text("Tunai". str_pad(number_format($transaction->cash), 27, ' ', STR_PAD_LEFT) . "\n");
            $printer->text("Kembalian". str_pad(number_format($transaction->change), 23, ' ', STR_PAD_LEFT) . "\n");
            $printer->text("================================\n");

            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("Tgl. " . date('d-m-Y H:i:s') . "\n");
            $printer->text("--------------------------------\n");

            $printer->feed();
            $printer->cut();
            $printer->close();

            return response()->json(['success' => true, 'message' => 'Printing Successful']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
