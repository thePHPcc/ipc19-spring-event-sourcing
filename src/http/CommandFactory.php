<?php declare(strict_types=1);

namespace Eventsourcing\Http;
use Eventsourcing\Factory;

class CommandFactory
{
    /**
     * @var Factory
     */
    private $factory;

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    public function createStartCheckoutCommand(): StartCheckoutCommand
    {
        return  new StartCheckoutCommand($this->factory->createStartCheckoutCommand());
    }

    public function createSetBillingAddressCommand(): SetBillingAddressCommand
    {
        return new SetBillingAddressCommand($this->factory);
    }
}
