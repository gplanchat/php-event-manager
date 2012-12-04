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
use stdClass;

class EventTest
    extends PHPUnit_Framework_TestCase
{
    public function testName()
    {
        $event = new Event('my_event_name');

        $this->assertEquals($event->getName(), 'my_event_name');
    }

    public function testEmptyName()
    {
        $this->setExpectedException('RuntimeException');
        new Event('');
    }

    public function testNullName()
    {
        $this->setExpectedException('RuntimeException');
        new Event(null);
    }

    public function testIntName()
    {
        $this->setExpectedException('RuntimeException');
        new Event(3);
    }

    public function testObjectName()
    {
        $this->setExpectedException('RuntimeException');
        new Event(new stdClass);
    }

    public function testExistentMetadata()
    {
        $event = new Event('my_event_name', ['my_event_data_key1' => 'my_event_data_value1']);
        $this->assertEquals($event->getData('my_event_data_key1'), 'my_event_data_value1');
    }

    public function testNotExistentMetadataUsingDefaultValue()
    {
        $event = new Event('my_event_name', ['my_event_data_key1' => 'my_event_data_value1']);
        $this->assertEquals($event->getData('my_event_data_key2', 'my_event_default_data_value'), 'my_event_default_data_value');
    }

    public function testNotExistentMetadataUsingNoDefaultValue()
    {
        $event = new Event('my_event_name', ['my_event_data_key1' => 'my_event_data_value1']);
        $this->assertNull($event->getData('my_event_data_key2'));
    }

    public function testIsStoppedWhileStopped()
    {
        $event = new Event('my_event_name');

        $event->stop();
        $this->assertTrue($event->isStopped());
    }

    public function testIsStoppedWhileNotStopped()
    {
        $event = new Event('my_event_name');

        $this->assertFalse($event->isStopped());
    }
}
