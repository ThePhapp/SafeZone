<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class RealtimeService
{
    public static function broadcast($event, $data)
    {
        try {
            Http::post(env('NODE_SERVER_URL') . '/broadcast', [
                'key'   => env('NODE_SERVER_KEY'),
                'event' => $event,
                'data'  => $data,
            ]);
        } catch (\Exception $e) {
            \Log::error('Realtime broadcast failed: ' . $e->getMessage());
        }
    }
}
