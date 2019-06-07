<?php declare(strict_types=1);

namespace Eventsourcing;
class BillingAddressEnteredTopic implements Topic
{
    public function asString(): string
    {
        return 'BillingAddressEntered';
    }

}
