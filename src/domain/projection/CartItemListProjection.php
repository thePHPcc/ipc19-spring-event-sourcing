<?php declare(strict_types=1);

namespace Eventsourcing;
class CartItemListProjection
{
    /**
     * @var string
     */
    private $markup;

    public function __construct(string $markup)
    {
        $this->markup = $markup;
    }

    public function getMarkup(): string
    {
        return $this->markup;
    }

}
