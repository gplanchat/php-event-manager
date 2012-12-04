<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Greg
 * Date: 28/11/12
 * Time: 08:40
 * To change this template use File | Settings | File Templates.
 */

namespace Test\Gplanchat\EventManager;

use PHPUnit_Framework_TestCase;
use Gplanchat\EventManager\Event;
use Gplanchat\EventManager\SharedEventEmitter;
use stdClass;

class SharedEventEmitterTest
    extends PHPUnit_Framework_TestCase
{
    protected function _getEventMock(array $methods = [], array $arguments = [])
    {
        return $this->getMock('Gplanchat\\EventManager\\Event', $methods, $arguments);
    }

    protected function _getEventEmitter()
    {
        return new SharedEventEmitter();
    }

    public function testRegisteringAndEmittingEvent()
    {
        $counter = 0;

        $eventEmitter = $this->_getEventEmitter();
        $eventEmitter->on('my_event_name', function(Event $e) use(&$counter) {$counter++;});

        $eventEmitter->emit(new Event('my_event_name'));
        $this->assertEquals(1, $counter);
    }

    public function testRegisteringAndEmittingEventMultipleTimes()
    {
        $counter = 0;

        $eventEmitter = $this->_getEventEmitter();
        $eventEmitter->on('my_event_name', function(Event $e) use(&$counter) {$counter++;});

        $eventEmitter->emit(new Event('my_event_name'));
        $eventEmitter->emit(new Event('my_event_name'));
        $this->assertEquals(2, $counter);
    }

    public function testRegisteringAndEmittingEventMultipleTimesWithUnitaryListener()
    {
        $counter = 0;

        $eventEmitter = $this->_getEventEmitter();
        $eventEmitter->once('my_event_name', function(Event $e) use(&$counter) {$counter++;});

        $eventEmitter->emit(new Event('my_event_name'));
        $eventEmitter->emit(new Event('my_event_name'));
        $this->assertEquals(1, $counter);
    }

    public function testRegisteringAndUnregisteringEvent()
    {
        $counter = 0;

        $eventEmitter = $this->_getEventEmitter();
        $callbackHandler = $eventEmitter->on('my_event_name', function(Event $e) use(&$counter) {$counter++;});

        $this->assertInstanceOf('Gplanchat\\EventManager\\CallbackHandler', $callbackHandler);

        $eventEmitter->removeListener('my_event_name', $callbackHandler);

        $eventEmitter->emit(new Event('my_event_name'));
        $this->assertEquals(0, $counter);
    }

    public function testRegisteringMultiAndEmittingEvent()
    {
        $counter = 0;

        $eventEmitter = $this->_getEventEmitter();
        $eventEmitter->on(['my_event_name1', 'my_event_name2'], function(Event $e) use(&$counter) {$counter++;});

        $eventEmitter->emit(new Event('my_event_name1'));

        $this->assertEquals(1, $counter);

        $eventEmitter->emit(new Event('my_event_name2'));

        $this->assertEquals(2, $counter);

        $eventEmitter->emit(new Event('my_event_name2'));

        $this->assertEquals(3, $counter);
    }

    public function testRegisteringMultiAndUnregisteringEvent()
    {
        $counter = 0;

        $eventEmitter = $this->_getEventEmitter();
        $callbackHandler = $eventEmitter->on(['my_event_name1', 'my_event_name2'], function(Event $e) use(&$counter) {$counter++;});

        $eventEmitter->removeListener('my_event_name1', $callbackHandler);

        $eventEmitter->emit(new Event('my_event_name1'));
        $this->assertEquals(0, $counter);

        $eventEmitter->emit(new Event('my_event_name2'));
        $this->assertEquals(1, $counter);
    }

    public function testRegisteringMultiAndUnregisteringMultiEvent()
    {
        $counter = 0;

        $eventEmitter = $this->_getEventEmitter();
        $callbackHandler = $eventEmitter->on(['my_event_name1', 'my_event_name2'], function(Event $e) use(&$counter) {$counter++;});

        $eventEmitter->removeListener(['my_event_name1', 'my_event_name2'], $callbackHandler);

        $eventEmitter->emit(new Event('my_event_name1'));
        $this->assertEquals(0, $counter);

        $eventEmitter->emit(new Event('my_event_name2'));
        $this->assertEquals(0, $counter);
    }
}
