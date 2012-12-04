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
trait EventTrait
{
    /**
     * @var string
     */
    protected $name = null;

    /**
     * @var bool
     */
    protected $isStopped = false;

    /**
     * @var array
     */
    private $data = [];

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return EventInterface
     */
    public function stop()
    {
        $this->isStopped = true;

        return $this;
    }

    /**
     * @return bool
     */
    public function isStopped()
    {
        return (bool) $this->isStopped;
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getData($key, $default = null)
    {
        if (!isset($this->data[(string) $key])) {
            return $default;
        }

        return $this->data[(string) $key];
    }
}
