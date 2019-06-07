<?php declare(strict_types=1);

namespace Eventsourcing\Checkout;
class CheckoutId
{
    /**
     * @var string
     */
    private $value;

    public function __construct(string $value = null)
    {
        if ($value === null) {
            $value = trim(exec('uuidgen'));
        }
        $this->value = $value;
    }

    public function asString(): string
    {
        return $this->value;
    }
}
