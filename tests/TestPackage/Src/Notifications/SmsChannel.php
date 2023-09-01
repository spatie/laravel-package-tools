<?php

namespace Spatie\LaravelPackageTools\Tests\TestPackage\Src\Notifications;

use Illuminate\Notifications\Notification;

class SmsChannel 
{
    public function send ($notifiable, Notification $notification) {
        return $notification;
    }
}
