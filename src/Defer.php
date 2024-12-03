<?php

declare(strict_types=1);

class Callback
{
    public function __construct(
        private mixed $cb,
        private array $args = [],
    ) {
    }

    public function call(): void
    {
        call_user_func_array($this->cb, $this->args);
    }
}

function add($a, $b)
{
    return  $a + $b;
}
function sub($a, $b)
{
    echo $a - $b;
}
class Defer
{
    public string $callableVar;
    public array $callableArray = [];
    public function __construct()
    {
    }
    public static function init(){

    }
    public function defer(string $callable)
    {
        $this->callableVar = $callable;
        array_push($this->callableArray, $callable);
    }

    public function __destruct()
    {
        print_r($this->callableArray);
        for ($i = count($this->callableArray)-1; $i >= 0; $i--) {
          echo  call_user_func_array($this->callableArray[$i], [6,2]);
        }
    }
}

function tryDefer()
{
    $obj = new Defer();
    $obj->defer('add');
    $obj->defer('sub');
}
tryDefer();
