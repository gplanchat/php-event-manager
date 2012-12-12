php-event-manager
=================

PHP events management library.

## Description

The event emitting manager let you implement callback-based event management, for implementing modular code or to make easier class reuse.

Event-based programming is currently available natively into multiple languages and brings some new ways of writing code. Having in mind that this pattern should be used to make code easier to maintain, this pattern should not be used in all cases, especially where other patterns are simpler to implement.

## Requirements

* PHP >= 5.4.0

## Unit testing

Run the following command to launch PHPUnit unit tests under the package root directory :

    $ phpunit --strict --configuration build/phpunit.xml

## Examples

You may find the following code examples useful.
Some more examples could be found in the unit tests suite in the tests/ folder.

### Basic usage with SharedEventEmitter

    $eventEmitter = new SharedEventEmitter();

    // Registering a callback for the event 'ready'
    $eventEmitter->on(['ready'], function(Event $e) {
        // Your event code comes here...
    });

    // ...

    // Calling the event
    $eventEmitter->emit(new Event('ready'));

### Passing datas into the Event

    $eventEmitter = new SharedEventEmitter();

    // Registering a callback for the event 'ready'
    $eventEmitter->on(['ready'], function(Event $e) {
        // Your event code comes here...
    });

    // ...

    // Calling the event
    $eventEmitter->emit(new Event('ready', [
        'my_object' => new stdClass
    ]));

### Passing datas into the Event, with a defined priority for the callback

    $priority = 100;
    $callback = function(Event $e) {
        // Your event code comes here...
    };

    $eventEmitter = new SharedEventEmitter();

    // Registering a callback for the event 'ready'
    $eventEmitter->on(['ready'], $callback, $priority);

    // ...

    // Calling the event
    $eventEmitter->emit(new Event('ready', [
        'my_object' => new stdClass
    ]));

### Passing datas during event emitting

    $eventEmitter = new SharedEventEmitter();

    // Registering a callback for the event 'ready'
    $eventEmitter->on(['ready'], function(Event $e, $isError, $object) {
        // Your event code comes here...
    });

    // ...

    // Calling the event,
    $eventEmitter->emit(new Event('ready'), false, new stdClass);

### Implement the EventEmitterInterface interface to build your own event emitters

You may implement this event emitter manager for adding event management to existing frameworks.

    class Application
        extends Foo\Framework\ApplicationAbstract
        implements EventEmitterInterface
    {
        use EventEmitterTrait;

        public function bootstrap()
        {
            // Bootstrap the instance...

            // emit the 'bootstrap' event, when your method has finished the basic bootstrapping
            $this->emit(new Event('bootstrap', ['application' => $this]));

            return $this;
        }
    }

    //...

    // Registering a callback for the event 'bootstrap'
    $eventEmitter->on(['bootstrap'], function(Event $e) {
        // Your event code comes here...
    });

    //...

    // Your caller code looks like this :
    $app = new Application();
    $app->bootstrap();
