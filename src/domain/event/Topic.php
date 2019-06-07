<?php declare(strict_types=1);

namespace Eventsourcing;
interface Topic
{
    public function asString(): string;
}
