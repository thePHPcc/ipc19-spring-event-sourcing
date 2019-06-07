<?php declare(strict_types=1);

namespace Eventsourcing;
use Eventsourcing\Checkout\CartItem;

class CartItemListProjector implements EventHandler
{
    /**
     * @var string
     */
    private $listTemplate;

    /**
     * @var string
     */
    private $itemTemplate;
    /**
     * @var string
     */
    private $filename;

    public function __construct(
        string $listTemplate, string $itemTemplate, string $filename
    )
    {
        $this->listTemplate = $listTemplate;
        $this->itemTemplate = $itemTemplate;
        $this->filename = $filename;
    }

    public function handle(Event $event): void
    {
        if (!$event instanceof CheckoutStartedEvent) {
            throw new UnsupportedEventException();
        }

        $itemMarkup = '';
        foreach ($event->getCartItems() as $cartItem) {
            /** @var CartItem $cartItem */
            $itemMarkup .= str_replace(
                ['ITEM_ID', 'ITEM_PRICE'],
                [(string)$cartItem->getId(), number_format($cartItem->getPrice() / 100, 2)], $this->itemTemplate
            );
        }
        $listMarkup = str_replace(
            'CART_ITEMS', $itemMarkup, $this->listTemplate
        );

        file_put_contents($this->filename, $listMarkup);
    }

    public function getSupportedEvents(): array
    {
        return [CheckoutStartedEvent::class];
    }
}
