<?php declare(strict_types=1);

namespace Eventsourcing;
use Eventsourcing\Mail\Mail;

class SendOrderConfirmationMailEventHandler implements EventHandler
{
    /**
     * @var MailService
     */
    private $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    public function handle(Event $event): void
    {
        if (!$event->getTopic() == new CheckoutCompletedTopic()) {
            throw new UnsupportedEventException();
        }
        /** @var CheckoutCompletedEvent $event
         */
        $mail = new Mail(
            'Thank you for your order',
            $event->getBillingAddress()->getEmail()
        );
        $this->mailService->send($mail);
    }

    public function getSupportedTopics(): array
    {
        return [new CheckoutCompletedTopic()];
    }

}
