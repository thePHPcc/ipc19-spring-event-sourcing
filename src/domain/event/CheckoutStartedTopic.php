<?php declare(strict_types=1);

namespace Eventsourcing;
class CheckoutStartedTopic implements Topic
{
    public function asString(): string
    {
        return 'CheckoutStarted';
    }

}
