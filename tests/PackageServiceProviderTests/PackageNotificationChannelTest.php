<?php

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertStringStartsWith;

use Spatie\LaravelPackageTools\Package;
use Illuminate\Support\Facades\Notification;

use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Notifications\SmsChannel;

trait ConfigurePackageNotificationChannelTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasNotificationChannel('sms',SmsChannel::class);
    }
}

uses(ConfigurePackageNotificationChannelTest::class);

it('can load custom notification channel', function () {
   $channel = Notification::channel('sms');

   assertEquals(get_class($channel),SmsChannel::class);

});
