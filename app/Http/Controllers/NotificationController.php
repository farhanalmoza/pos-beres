<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Notifications\InvoicePaid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    public function sendMessage()
    {
        $message = "Ini adalah pesan dari bot Laravel!";
        
        // Kirim notifikasi
        Notification::route('telegram', '6281395161765')
            ->notify(new InvoicePaid($message));
            
        return response()->json(['message' => 'Pesan terkirim!']);
    }
}
