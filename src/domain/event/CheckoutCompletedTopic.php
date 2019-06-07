<?php declare(strict_types=1);

namespace Eventsourcing;
class CheckoutCompletedTopic implements Topic
{
    public function asString(): string
    {
        return 'CheckoutCompleted';
    }

}
