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
            'userId' => $event->user->id,
            'userUuid' => $event->user->uuid,
            'headers' => $this->requestHeaders(),
        ]);
    }
}
