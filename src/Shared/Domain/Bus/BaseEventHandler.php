<?php

declare(strict_types=1);

namespace Shared\Domain\Bus;

use Shared\Domain\Messaging\Message;

abstract class BaseEventHandler implements EventHandler
{
    /** @throws \Exception */
    public function on(Message $message)
    {
        $method = 'on' . substr(strrchr(get_class($message), '\\'), 1);
        if (!method_exists($this, $method)) {
            $errorMessage = sprintf(
                'Impossible to call method: %s in class: %s', $method, get_class($this)
            );
            throw new \Exception($errorMessage);
        }
        
        $this->$method($message);
    }
}
