<?php

namespace App\Observers\Log;


use App\Traits\RequestHeadersTrait;
use App\User;
use App\LogUser;

class LogUserObserver
{

    use RequestHeadersTrait;

    /**
     * @var LogUser
     */
    private $logUser;

    /**
     * LogUserObserver constructor.
     * @param LogUser $logUser
     */
    public function __construct(LogUser $logUser)
    {
        $this->logUser = $logUser;
    }


    /**
     * @param User $user
     */
    public function created(User $user)
    {
        $this->logUser->create([
            'action' => 'CREATED',
            'user_id' => $user->id,
            'user_uuid' => $user->user_uuid,
            'headers' => $this->requestHeaders(),
        ]);
    }


    public function updated(User $user)
    {

        $this->logUser->create([
            'action' => 'UPDATED',
            'user_id' => $user->id,
            'user_uuid' => $user->user_uuid,
            'headers' => $this->requestHeaders(),
        ]);
    }


    public function deleted(User $user)
    {

        $this->logUser->create([
            'action' => 'DELETED',
            'user_id' => $user->id,
            'user_uuid' => $user->user_uuid,
            'headers' => $this->requestHeaders(),
        ]);
    }

}
