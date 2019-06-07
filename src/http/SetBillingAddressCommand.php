<?php declare(strict_types=1);

namespace Eventsourcing\Http;
use Eventsourcing\Factory;
use Slim\Http\Request;

class SetBillingAddressCommand
{
    /**
     * @var Factory
     */
    private $factory;

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    public function execute(Request $request)
    {
        $billingAddress = new \Eventsourcing\Checkout\BillingAddress(
            $request->getParam('firstname'),
            $request->getParam('lastname'),
            $request->getParam('email'),
            $request->getParam('street'),
            $request->getParam('zip'),
            $request->getParam('city'),
            $request->getParam('country')
        );
        $this->factory->createSetBillingAddressCommand($billingAddress)->execute();
    }
}
