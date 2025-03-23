<?php

namespace App\Listeners;


use App\Infrastracture\Events\RegisterUserEvent;
use App\Infrastracture\Notifications\NewAvailableUser;

use App\Models\SubDomains\User;
use App\Models\ValueObjects\Role;

class SendNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(RegisterUserEvent $event): void
    {

        User::where('role','admin')->each(function ($user) use ($event) {
            $user->notify(new NewAvailableUser('System',$event->user));
        });

    }
}
