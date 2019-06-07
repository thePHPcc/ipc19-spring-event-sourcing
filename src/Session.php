<?php declare(strict_types=1);

namespace Eventsourcing;
use Eventsourcing\Checkout\CheckoutId;

class Session
{
    public function __construct()
    {
        session_name('checkout_demo_session');
        session_start();
    }

    public function getCheckoutId(): CheckoutId
    {
        if (!isset($_SESSION['checkoutId'])) {
            $_SESSION['checkoutId'] = new CheckoutId();
        }

        return $_SESSION['checkoutId'];
    }

    public function getId(): SessionId
    {
       return new SessionId(session_id());
    }

    public function hasCheckoutId(): bool
    {
        return array_key_exists('checkoutId', $_SESSION);
    }
}
