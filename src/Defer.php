<?php

declare(strict_types=1);
namespace Solo312;

// Callback class to manage callbacks and their arguments.
class Callback
{
    // Constructor that takes a callable and an array of arguments.
    public function __construct(
        private mixed $cb,  // The callable to execute.
        private array $args = []  // The arguments to pass to the callable.
    ) {}

    // Executes the callable with the provided arguments.
    public function call(): void
    {
        // Calls the callable with the arguments using call_user_func_array.
        call_user_func_array($this->cb, $this->args);
    }
}



// Defer class to manage adding and executing callbacks.
class Defer 
{
    // Array to store the callbacks.
    private array $callableArray = [];

    // Empty constructor, no initialization needed.
    public function __construct()
    {
    }

    public static function init(callable $callable, array $args = []): self
    {
        // Creates a Defer instance and adds a callback via defer().
        $instance = new self();
        $instance->defer($callable, $args);
        return $instance;
    }

    // Magic method __invoke to allow the object to be called directly as a function.
    public function __invoke(callable $callable, array $args = []): void
    {
        // Adds the callback to the stack with its arguments.
        $this->defer($callable, $args);
    }

    // Method to add a callback to the stack.
    public function defer(callable $callable, array $args = []): void
    {
        // Creates a Callback object and adds it to the stack.
        $callback = new Callback($callable, $args);
        $this->callableArray[] = $callback;  
    }

    // Destructor called when the object is destroyed, executing all callbacks in reverse order.
    public function __destruct()
    {
        // Traverses the callback stack in reverse order (LIFO).
        for ($i = count($this->callableArray) - 1; $i >= 0; $i--) {
            // Executes each callback.
            $this->callableArray[$i]->call();
        }
    }
}
