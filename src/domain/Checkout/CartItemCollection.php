<?php declare(strict_types=1);

namespace Eventsourcing\Checkout;
class CartItemCollection implements \Countable, \IteratorAggregate
{
    /**
     * @var CartItem[]
     */
    private $items = [];

    public function __construct(array $items)
    {
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->items);
    }

    private function add(CartItem $cartItem): void
    {
        $this->items[] = $cartItem;
    }
}
