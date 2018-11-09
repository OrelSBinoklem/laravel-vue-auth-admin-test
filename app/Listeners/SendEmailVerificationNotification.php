<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use App\Events\ChangeEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class SendEmailVerificationNotification
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Registered  $event
     * @return void
     */
    public function handle($event)
    {
        if($event instanceof Registered || $event instanceof ChangeEmail) {
            if ($event->user instanceof MustVerifyEmail && ! $event->user->hasVerifiedEmail()) {
                $event->user->sendEmailVerificationNotification();
            }
        }
    }
}
