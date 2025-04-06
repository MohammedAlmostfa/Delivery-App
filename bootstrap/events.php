<?php

use App\Events\Registered;
use App\Listeners\SendVerificationEmail;
use Illuminate\Events\Dispatcher;

return function (Dispatcher $events) {
    $events->listen(
        Registered::class,
        SendVerificationEmail::class
    );
};
