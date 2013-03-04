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

/**
 * @namespace
 */
namespace Gplanchat\EventManager;

/**
 *
 */
interface EventInterface
{
    /**
     * @abstract
     * @return string
     */
    public function getName();

    /**
     * @abstract
     * @return EventInterface
     */
    public function stop();

    /**
     * @abstract
     * @return bool
     */
    public function isStopped();

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getData($key, $default = null);

    /**
     * @param string $key
     * @param mixed $value
     * @return EventInterface
     */
    public function setData($key, $value);

    /**
     * @param string $key
     * @param mixed $value
     * @return EventInterface
     */
    public function setEventEmitter(EventEmitterInterface $eventEmitter);
}
