<?php declare(strict_types=1);

namespace Eventsourcing;

use Eventsourcing\Cart\CartNotFoundException;
use Eventsourcing\SessionId;
use PHPUnit\Framework\TestCase;

class CartServiceTest extends TestCase
{
    /**
     * @var CartService
     */
    private $service;

    protected function setUp(): void
    {
        $this->service = new CartService();
    }

    public function testThrowsExceptionIfSessionIdIsNotKnown(): void
    {
        $this->expectException(CartNotFoundException::class);
        $this->service->getCartItems(new SessionId('foo'));
    }

    /**
     * @dataProvider sessionIdProvider
     *
     * @param SessionId $sessionId
     * @param int $expectedCount
     * @throws CartNotFoundException
     */
    public function testReturnsCartItemCollectionWithExpectedAmountOfItems(SessionId $sessionId, int $expectedCount): void
    {
        $collection = $this->service->getCartItems($sessionId);
        $this->assertCount($expectedCount, $collection);
    }

    public function sessionIdProvider(): array
    {
        return [
            [new SessionId('ihgorhmtcvo3qmd5as2oi7thpf'), 1],
            [new SessionId('has4t1glskcktjh4ujs9eet26u'), 5],
            [new SessionId('10603jjdasv8vpid64t214762l'), 25],
        ];
    }
}
