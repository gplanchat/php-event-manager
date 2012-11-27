<?php
/**
 * This file is part of php-event-manager.
 *
 * php-event-manager is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * php-event-manager is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.

 * You should have received a copy of the GNU Lesser General Public License
 * along with php-event-manager.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author  Grégory PLANCHAT<g.planchat@gmail.com>
 * @licence GNU Lesser General Public Licence (http://www.gnu.org/licenses/lgpl-3.0.txt)
 */

namespace Gplanchat\EventManager;

use SplQueue;

/**
 *
 */
trait EventEmitterTrait
{
    /**
     * @var array
     */
    private $eventListeners = array();

    /**
     * @param string|array $eventName
     * @param callable $listener
     * @param bool $isCalledOnce
     * @return EventEmitterInterface
     */
    private function _registerEvent($eventName, callable $listener, $isCalledOnce = false)
    {
        if (!isset($this->eventListeners[$eventName])) {
            $this->eventListeners[$eventName] = array();
        }

        $eventEntry = array(
            'callback'       => $listener,
            'is_called_once' => (bool) $isCalledOnce
        );
        $this->eventListeners[$eventName][] = $eventEntry;

        return $eventEntry;
    }

    /**
     * @param string|array $eventName
     * @param callable $listener
     * @return EventEmitterInterface
     * @throws \RuntimeException
     */
    public function on($eventName, callable $listener)
    {
        $eventName = (string) $eventName;
        if (empty($eventName)) {
            throw new \RuntimeException('Could not register event, event name should be a non-empty string.');
        }

        $this->_registerEvent($eventName, $listener, false);

        return $this;
    }

    /**
     * @param string|array $eventName
     * @param callable $listener
     * @return CallbackHandler
     * @throws \RuntimeException
     */
    public function once($eventName, callable $listener)
    {
        $eventName = (string) $eventName;
        if (empty($eventName)) {
            throw new \RuntimeException('Could not register event, event name should be a non-empty string.');
        }

        $this->_registerEvent($eventName, $listener, true);

        return $this;
    }

    /**
     * @param string|array $eventName
     * @param callable $callback
     * @return EventEmitterInterface
     * @throws \RuntimeException
     */
    public function removeListener($eventName, callable $callback)
    {
        $eventName = (string) $eventName;
        if (empty($eventName)) {
            throw new \RuntimeException('Could not remove event listeners, event name should be a non-empty string.');
        }

        if (!isset($this->eventListeners[$eventName])) {
            return $this;
        }

        foreach ($this->eventListeners[$eventName] as $key => $eventEntry) {
            if ($eventEntry === $callback) {
                unset($this->eventListeners[$eventName][$key]);
                break;
            }
        }

        return $this;
    }

    /**
     * @param string|array $eventName
     * @return EventEmitterInterface
     * @throws \RuntimeException
     */
    public function removeAllListeners($eventName)
    {
        $eventName = (string) $eventName;
        if (empty($eventName)) {
            throw new \RuntimeException('Could not remove event listeners, event name should be a non-empty string.');
        }

        if (!isset($this->eventListeners[$eventName])) {
            return $this;
        }

        unset($this->eventListeners[$eventName]);

        return $this;
    }

    /**
     * @param string|array $eventName
     * @return array
     * @throws \RuntimeException
     */
    public function getListeners($eventName)
    {
        $eventName = (string) $eventName;
        if (empty($eventName)) {
            throw new \RuntimeException('Could not get event listeners, event name should be a non-empty string.');
        }

        if (!isset($this->eventListeners[$eventName])) {
            return [];
        }

        $result = [];
        foreach ($this->eventListeners[$eventName] as $eventEntry) {
            $result[] = $eventEntry->listener;
        }

        return $result;
    }

    /**
     * @param EventInterface $event
     * @param array $params
     * @return EventEmitterInterface
     * @throws \RuntimeException
     */
    public function emit(EventInterface $event, Array $params = [])
    {
        $eventName = $event->getName();
        if (empty($eventName)) {
            throw new \RuntimeException('Could not trigger event, event name should be a non-empty string.');
        }

        if (!isset($this->eventListeners[$eventName])) {
            return $this;
        }

        array_unshift($params, $event);
        foreach ($this->eventListeners[$eventName] as $eventIndex => $eventEntry) {
            call_user_func_array($eventEntry['callback'], $params);

            if ($eventEntry['is_called_once']) {
                unset($this->eventListeners[$eventName][$eventIndex]);
            }

            if ($event->isStopped()) {
                break;
            }
        }

        return $this;
    }
}
