<?php declare(strict_types=1);

namespace Eventsourcing\Http;
class StartCheckoutCommand
{
    /**
     * @var \Eventsourcing\StartCheckoutCommand
     */
    private $startCheckoutCommmand;

    public function __construct(\Eventsourcing\StartCheckoutCommand $startCheckoutCommmand)
    {
        $this->startCheckoutCommmand = $startCheckoutCommmand;
    }

    public function execute(): void
    {
        $this->startCheckoutCommmand->execute();
    }
}
