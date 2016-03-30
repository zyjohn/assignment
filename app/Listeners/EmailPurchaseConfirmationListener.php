<?php

namespace App\Listeners;

use App\Events\CartPurchasedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailPurchaseConfirmationListener implements ShouldQueue {

    use InteractsWithQueue;

    public function handle(CartPurchasedEvent $event) {
        //We can check log to see the email will be queued and triggered with info needed
        error_log($event->getMessage(), 3, '/tmp/php.log');
        //Todo: pass Mail class to send email with correct format
        //mail('youremail@yourdomain.com', $event->getTitle(), $event->getMessage());
    }

}
