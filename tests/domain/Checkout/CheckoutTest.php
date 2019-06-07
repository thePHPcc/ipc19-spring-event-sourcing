<?php declare(strict_types=1);

namespace Eventsourcing\Checkout;
use Eventsourcing\CheckoutStartedEvent;
use Eventsourcing\EventLog;
use Eventsourcing\SessionId;
use PHPUnit\Framework\TestCase;

class CheckoutTest extends TestCase
{
    public function testCheckoutCannotBeStartedTwice(): void
    {
        $eventLog = new EventLog();
        $eventLog->add(new CheckoutStartedEvent(
            new CartItemCollection([]), new SessionId('foo'), new \DateTimeImmutable('2019-06-07 10:25:00')
        ));
        $currentDateTime = new \DateTimeImmutable('2019-06-07 10:27:00');
        $checkout = new Checkout($eventLog, $currentDateTime);
        $this->expectException(CheckoutAlreadyStartedException::class);
        $checkout->startCheckout(new CartItemCollection([]), new SessionId('foo'));
    }

    public function testCheckoutCanBeStarted(): void
    {
        $eventLog = new EventLog();
        $currentDateTime = new \DateTimeImmutable('2019-06-07 10:27:00');
        $checkout = new Checkout($eventLog, $currentDateTime);
        $cartItems = new CartItemCollection([]);
        $sessionId = new SessionId('foo');
        $checkout->startCheckout($cartItems, $sessionId);

        $expectedEvent = new CheckoutStartedEvent($cartItems, $sessionId, $currentDateTime);
        $this->assertCount(1, $eventLog);

        foreach ($eventLog as $event) {
            $this->assertEquals($expectedEvent, $event);
        }

    }
}
