<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    /**
     * Write code on Method
     *
     * @return bool
     */
    public function sendNotification(): bool
    {
        $data = [
            "title" => "Red Eagle Suisse: Mit dem TRITON strebt...",
            "body" => "Mit der aeronautischen Drohne TRITON streben Ulrich T. Grabowski und die Red Eagle Suisse einen idealen Schutz für Industrieanlagen an.",
            "image" => "https://meraner-morgen.it/wp-content/uploads/2021/01/TRITON.jpg"
        ];

        $deviceTokens = [env('FIREBASE_TEST_DEVICE_TOKEN')];
        return \Artisan::call("send:notification", [
            'notificationData' => $data,
            'deviceTokens' => $deviceTokens
        ]);
    }
}
