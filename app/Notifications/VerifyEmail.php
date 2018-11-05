<?php

namespace App\Notifications;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailFramework;

class VerifyEmail extends VerifyEmailFramework {
    protected function verificationUrl($notifiable)
    {
        //delete "/api"
        return URL::to(
            substr ( URL::temporarySignedRoute(
                'verification.verify', Carbon::now()->addMinutes(60), ['id' => $notifiable->getKey()], false
            ), 4)
        );
    }
}