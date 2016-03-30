<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;

class CartPurchasedEvent extends Event {

    use SerializesModels;

    private $message;
    private $title;

    public function __construct($title, $message) {
        $this->message = $message;
        $this->title = $title;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getTitle() {
        return $this->title;
    }

}
