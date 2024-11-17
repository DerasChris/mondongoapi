// routes/api.php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

Route::post('/send-topic-notification', [NotificationController::class, 'sendTopicNotification']);