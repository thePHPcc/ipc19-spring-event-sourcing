<?php declare(strict_types=1);

namespace Eventsourcing;

use Eventsourcing\SessionId;
use PHPUnit\Framework\TestCase;

class SessionIdTest extends TestCase
{
    public function testReturnsExpectedString(): void
    {
        $sessionId = new SessionId('foo');
        $this->assertSame('foo', $sessionId->asString());
    }
}
