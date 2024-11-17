<?php

namespace App\Http\Controllers;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    private $messaging;

    public function __construct()
    {
        $firebase = (new Factory)
            ->withServiceAccount(env('FIREBASE_CREDENTIALS_PATH'))
            ->create();

        // Aquí inicializas el servicio de mensajería
        $this->messaging = $firebase->getMessaging();
    }

    public function sendPushNotification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_token' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $deviceToken = $request->input('device_token');

        $message = CloudMessage::new()
            ->withNotification(Notification::create('Nuevo Trabajo', 'Creemos que esta solicitud te puede interesar.'))
            ->withTarget('token', $deviceToken);

        try {
            $this->messaging->send($message);
            return response()->json(['message' => 'Notificación enviada exitosamente']);
        } catch (\Exception $e) {
            \Log::error('Error al enviar notificación: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function sendTopicNotification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'topic' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $topic = $request->input('topic');

        $message = CloudMessage::new()
            ->withNotification(Notification::create('Nuevo Trabajo', 'Creemos que esta solicitud te puede interesar.'))
            ->withTarget('topic', $topic);

        try {
            $this->messaging->send($message);
            return response()->json(['message' => 'Notificación enviada a tema']);
        } catch (\Exception $e) {
            \Log::error('Error al enviar notificación: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}