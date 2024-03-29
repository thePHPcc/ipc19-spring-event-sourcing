<?php declare(strict_types=1);

namespace Eventsourcing;
use Eventsourcing\Checkout\BillingAddress;
use Eventsourcing\Checkout\CheckoutService;
use Eventsourcing\Http\CommandFactory;
use Eventsourcing\Http\QueryFactory;

class Factory
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var Session
     */
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function createCheckoutService(): CheckoutService
    {
        return new CheckoutService(
            $this->createEventLogReader(),
            $this->createEventLogWriter(),
            $this->createEventListener()
        );
    }

    public function createStartCheckoutCommand(): StartCheckoutCommand
    {
        return new StartCheckoutCommand(
            $this->createCartService(),
            $this->createCheckoutService()
        );
    }

    public function createSetBillingAddressCommand(BillingAddress $billingAddress): SetBillingAddressCommand
    {
        return new SetBillingAddressCommand(
            $this->createCheckoutService(),
            $billingAddress
        );
    }

    public function createCompleteCheckoutCommand(): CompleteCheckoutCommand
    {
        return new CompleteCheckoutCommand(
            $this->createCheckoutService()
        );
    }

    public function createHttpQueryFactory(): QueryFactory
    {
        return new QueryFactory($this->session);
    }

    public function createHttpCommandFactory(): CommandFactory
    {
        return new CommandFactory($this);
    }

    private function createCartService(): CartService
    {
        return new CartService($this->session->getId());
    }

    private function createEventListener(): EventListener
    {
        $eventListener = new EventListener();
        $eventListener->register($this->createCartItemListProjector());

        return $eventListener;
    }

    private function createEventLogReader(): EventLogReader
    {
        return new PdoEventLoadReader($this->createPdo(), $this->session->getCheckoutId());
    }

    private function createEventLogWriter(): EventLogWriter
    {
        return new PdoEventLogWriter($this->createPdo(), $this->session->getCheckoutId());
    }

    private function createCartItemListProjector(): CartItemListProjector
    {
        return new CartItemListProjector(
            file_get_contents(__DIR__ . '/../conf/templates/cartItemList.html'),
            file_get_contents(__DIR__ . '/../conf/templates/cartItem.html'),
            __DIR__ . '/../var/projections/cartItems_' . $this->session->getId()->asString() . '.html'
        );
    }

    private function createPdo(): \PDO
    {
        if ($this->pdo === null) {
            $this->pdo = new \PDO('sqlite:' . __DIR__ . '/../var/events.db');
        }

        return $this->pdo;
    }
}
