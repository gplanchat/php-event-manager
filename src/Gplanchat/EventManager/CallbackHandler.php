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
class CallbackHandler implements CallbackHandlerInterface
{
    /**
     * @var callable
     */
    private $callback = null;

    /**
     * @var array
     */
    private $data = [];

    /**
     * @param $callback
     * @param array $data
     */
    public function __construct(callable $callback, array $data = [])
    {
        $this->callback = $callback;
        $this->data = $data;
    }

    /**
     * @param $key
     * @param null $default
     * @return null
     */
    public function getData($key, $default = null)
    {
        if (!isset($this->data[(string) $key])) {
            return $default;
        }
        return $this->data[(string) $key];
    }

    /**
     * @param array $parameters
     * @return mixed
     */
    public function call(array $parameters = [])
    {
        return call_user_func_array($this->callback, $parameters);
    }

    /**
     * @return mixed
     */
    public function __invoke()
    {
        return $this->call(func_get_args());
    }

    /**
     * @param callable $callback
     * @return CallbackHandler
     */
    public function setCallback(callable $callback)
    {
        $this->callback = $callback;

        return $this;
    }

    /**
     * @return callable
     */
    public function getCallback()
    {
        return $this->callback;
    }
}
