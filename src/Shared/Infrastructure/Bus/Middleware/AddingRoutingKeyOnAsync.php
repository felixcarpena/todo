<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Middleware;

use Enqueue\MessengerAdapter\EnvelopeItem\TransportConfiguration;
use Shared\Domain\Messaging\AsyncMessage;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class AddingRoutingKeyOnAsync implements MiddlewareInterface
{
    public function setRoutingKey($key){
        $key = $key;
    }
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $message = $envelope->getMessage();
        if($message instanceof AsyncMessage){
            $envelope = $envelope->with(new TransportConfiguration(
                [
                    'metadata' => [
                        'routingKey' => $message->topic()
                    ]
                ]
            ));
        }

        return $stack->next()->handle($envelope, $stack);
    }
}
