<?php
namespace Gplanchat\EventManager;

interface CallbackHandlerInterface 
{
    /**
     * @param callable $callback
     * @return CallbackHandler
     */
    public function setCallback(callable $callback);

    /**
     * @return callable
     */
    public function getCallback();
}