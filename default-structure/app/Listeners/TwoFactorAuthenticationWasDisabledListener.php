<?php

namespace App\Listeners;

use App\Contracts\UserRepository;
use App\Notifications\TwoFactorAuthenticationWasDisabledNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class TwoFactorAuthenticationWasDisabledListener implements ShouldQueue
{
    use Queueable;

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->onQueue('notifications');
    }

    public function handle($event)
    {
        $this->userRepository->setNewEmailTokenConfirmation($event->user->id);

        Notification::send($event->user, new TwoFactorAuthenticationWasDisabledNotification());
    }
}
