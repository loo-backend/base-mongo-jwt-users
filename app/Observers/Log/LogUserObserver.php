<?php

namespace App\Observers;


use App\User;
use App\LogUser;

class LogUserObserver
{
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
            'user_uuid'
        ]);


    }
}
