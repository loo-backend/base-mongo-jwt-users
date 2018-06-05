<?php

namespace App\Listeners\Log\User;

use App\Events\Log\User\UserAuthenticateEvent;
use App\LogAuthenticate;
use App\Traits\RequestHeadersTrait;

class UserAuthenticateListener
{

    use RequestHeadersTrait;

    /**
     * Handle the event.
     *
     * @param UserAuthenticateEvent $event
     */
    public function handle(UserAuthenticateEvent $event)
    {
        LogAuthenticate::create([
            'user_id' => $event->user->id,
            'user_uuid' => $event->user->user_uuid,
            'headers' => $this->requestHeaders(),
        ]);
    }
}
