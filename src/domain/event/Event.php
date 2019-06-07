<?php declare(strict_types=1);

namespace Eventsourcing;
interface Event
{
    public function getOccuredAt(): \DateTimeImmutable;
}
