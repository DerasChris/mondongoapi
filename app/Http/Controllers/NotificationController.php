<?php

namespace App\Http\Controllers;

use Kreait\Firebase\Messaging;
use Kreait\Firebase\Factory;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    private $messaging;

    public function __construct()
    {
        $this->messaging = (new Factory)->createMessaging();
    }

    public function sendPushNotification(Request $request)
    {
        $deviceToken = $request->input('device_token'); // El token del dispositivo

        $message = CloudMessage::withTarget($deviceToken)
            ->withNotification(Notification::create('Nuevo Trabajo', 'Creemos que esta solicitud te puede interesar.'));

        try {
            $this->messaging->send($message);
            return response()->json(['message' => 'Notificación enviada exitosamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function sendTopicNotification(Request $request)
    {
        $topic = $request->input('workers');

        $message = CloudMessage::withTarget($topic)
            ->withNotification(Notification::create('Nuevo Trabajo', 'Creemos que esta solicitud te puede interesar.'));

        try {
            $this->messaging->send($message);
            return response()->json(['message' => 'Notificación enviada a tema']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
