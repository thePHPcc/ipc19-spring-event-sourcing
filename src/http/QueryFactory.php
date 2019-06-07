<?php declare(strict_types=1);

namespace Eventsourcing\Http;
use Eventsourcing\BillingAddressFormQuery;
use Eventsourcing\Checkout\BillingAddress;
use Eventsourcing\Factory;
use Eventsourcing\Session;

class QueryFactory
{
    /**
     * @var Session
     */
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function createBillingAddressFormQuery(): BillingAddressFormQuery
    {
        return new BillingAddressFormQuery($this->session);
    }
}
