<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Middleware;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class FinishesHandlingMessageBeforeHandlingNext implements MiddlewareInterface
{
    /** @var array */
    private $queue = [];
    /** @var bool */
    private $isHandling = false;

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $this->queue[] = $envelope;
        if (!$this->isHandling) {
            $this->isHandling = true;
            while ($message = array_shift($this->queue)) {
                try {
                    $stack->next()->handle($envelope, $stack);
                } finally {
                    $this->isHandling = false;
                }
            }
            $this->isHandling = false;
        }

        return $envelope;
    }
}
