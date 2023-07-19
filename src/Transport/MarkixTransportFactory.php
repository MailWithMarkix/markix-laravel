<?php

namespace Markix\Laravel\Transport;

use Exception;
use Illuminate\Support\Facades\Log;
use Markix\MarkixClient;
use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\MessageConverter;

class MarkixTransportFactory extends AbstractTransport
{
    /**
     * Create a new Markix transport instance.
     */
    public function __construct(
        protected MarkixClient $markixClient,
    )
    {
        parent::__construct();
    }

    /**
     * {@inheritDoc}
     */
    protected function doSend(SentMessage $message): void
    {
        $email = MessageConverter::toEmail($message->getOriginalMessage());

        $data = [
            'from' => $this->mapAddress($email->getFrom()[0]),
            'to' => array_map([$this, 'mapAddress'], $email->getTo()),
            'bcc' => array_map([$this, 'mapAddress'], $email->getBcc()),
            'cc' => array_map([$this, 'mapAddress'], $email->getCc()),
            'reply_to' => array_map([$this, 'mapAddress'], $email->getReplyTo()),

            'subject' => $email->getSubject(),
            'text_body' => $email->getTextBody(),
            'html_body' => $email->getHtmlBody(),

            'attachments' => array_map(function ($attachment) {
                return [
                    'name'    => $attachment->getName(),
                    'content' => base64_encode($attachment->bodyToString()),
                    'type'    => $attachment->getMediaType(),
                ];
            }, $email->getAttachments()),
        ];

        $this->markixClient->messages->send($data);
    }

    protected function mapAddress(Address $address): array
    {
        return [
            'name'  => $address->getName(),
            'address' => $address->getAddress(),
        ];
    }

    /**
     * Get the string representation of the transport.
     */
    public function __toString(): string
    {
        return 'markix';
    }
}
