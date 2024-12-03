<?php declare(strict_types=1);

class Callback {
    public function __construct(
        private mixed $cb,
        private array $args = [],
    ) {}

    public function call(): void {
        call_user_func_array($this->cb, $this->args);
    }
}

class Defer {
    public function __construct() {}

    public function __destruct() {}
}
?>

<?php

declare(strict_types=1);
// implements Iterator
class FibonacciSequence 
{
    private array $sequence;
    private int $index = 0;

    public function __construct(int $n)
    {
        $this->fibonacci($n);
    }

    // public static function first(int $n): self
    // {
    //     return;
    // }

    // public static function range(int $start, int $length = -1): self
    // {
    //     return;
    // }

    public function current(): mixed
    {
    }

    public function key(): mixed
    {
    }

    public function next(): void
    {
    }

    public function rewind(): void
    {
    }

    public function valid(): bool
    {
        return true;
    }

    public function fibonacci(int $n): int
    {
        if ($n == 0) {
            
            return 0;
        }
        if ($n == 1) {
            return 1;
        }

        $previous1 = 0;
        $previous2 = 1;
        $current = 0;

        for ($i = 2; $i <= $n; $i++) {
            $current = $previous1 + $previous2;
            $previous1 = $previous2;
            $previous2 = $current;
        }
        return $current;
    }
}

$obj= new FibonacciSequence(7);
echo $obj->fibonacci(7);