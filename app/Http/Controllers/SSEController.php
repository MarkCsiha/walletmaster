<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\tartozasok;

class SSEController extends Controller
{
    public function stream(Request $request)
    {
        $headers = [
            "Content-Type" => "text/event-stream",
            "Cache-Control" => "no-cache",
            "Connection" => "keep-alive",
            "X-Accel-Buffering" => "no",
        ];

        return response()->stream(function () {
            while (true) {
                // Fetch the unread notifications for the authenticated user
                $notifications = tartozasok::where('user_id', Auth::id())
                                             ->where('statusz', "függőben")  // For now, hardcoding the user ID, you can replace it with Auth::id() for dynamic user handling
                                             ->get();

                // If there are notifications, send them to the frontend
                if ($notifications->isNotEmpty()) {
                    // Format notifications as JSON and send them via SSE
                    echo "data: " . json_encode($notifications) . "\n\n";
                }

                // Flush the output buffer
                ob_flush();
                flush();

                // Sleep for a few seconds before checking again
                sleep(5);
            }
        }, 200, $headers);
    }
}
