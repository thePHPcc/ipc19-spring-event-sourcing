<?php declare(strict_types=1);

namespace Eventsourcing;

use Eventsourcing\Mail\Mail;
use PHPUnit\Framework\TestCase;

class MailTest extends TestCase
{
    public function testReturnsExpectedSubject(): void
    {
        $mail = new Mail('some subject', 'jane.doe@example.com');
        $this->assertSame('some subject', $mail->getSubject());
    }
    public function testReturnsExpectedRecipientAddress(): void
    {
        $mail = new Mail('some subject', 'jane.doe@example.com');
        $this->assertSame('jane.doe@example.com', $mail->getRecipientAddress());
    }
}
