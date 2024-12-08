<?php

declare(strict_types=1);

class FibonacciSequence implements Iterator
{
    private array $sequence = [];
    private int $index = 0;
    private int $start;
    private int $length;

    // Constructor to initialize the sequence based on start and length
    public function __construct(int $start, int $length)
    {
        $this->start = $start;
        $this->length = $length;
    }

    // Optimized calculation to calculate Fibonacci numbers lazily
    private function optimizedCalcul(int $index): void
    {
        // Calculate Fibonacci numbers up to the requested index, if not already cached
        for ($i = count($this->sequence); $i <= $index; $i++) {
            if ($i === 0) {
                $this->sequence[0] = 0;
            } elseif ($i === 1) {
                $this->sequence[1] = 1;
            } else {
                // Calculate Fibonacci using previously calculated terms
                $this->sequence[$i] = $this->sequence[$i - 1] + $this->sequence[$i - 2];
            }
        }
    }

    // Iterator interface methods
    public function current(): mixed
    {
        // Ensure we calculate the Fibonacci number at the current index
        $this->optimizedCalcul($this->start + $this->index);
        return $this->sequence[$this->start + $this->index];
    }

    public function key(): mixed
    {
        return $this->index;
    }

    public function next(): void
    {
        $this->index++;
    }

    public function rewind(): void
    {
        $this->index = 0;
    }

    public function valid(): bool
    {
        return $this->index < $this->length;
    }

    // Getter for the sequence
    public function getSequence(): array
    {
        return $this->sequence;
    }

    // Static method to get the first N terms of the Fibonacci sequence
    public static function first(int $n): self
    {
        return new self(0, $n); // Start from index 0, calculate N terms
    }

    // Static method to get a range of Fibonacci numbers starting from a given index
    public static function range(int $start, int $length): self
    {
        return new self($start, $length); // Start from the specified index, calculate 'length' terms
    }
}

// Testing the FibonacciIterator

echo "Fibonacci (first 5 terms):\n";
$fibonacciFirst = FibonacciSequence::first(5);  // First 5 terms
foreach ($fibonacciFirst as $index => $value) {
    echo "Index $index : $value\n";
}
// Expected output:
// Index 0 : 0
// Index 1 : 1
// Index 2 : 1
// Index 3 : 2
// Index 4 : 3

echo "\nFibonacci (range starting at index 5 for 5 terms):\n";
$fibonacciRange = FibonacciSequence::range(5, 5);  // Start at index 5, next 5 terms
foreach ($fibonacciRange as $index => $value) {
    echo "Index $index : $value\n";
}
// Expected output:
// Index 0 : 5
// Index 1 : 8
// Index 2 : 13
// Index 3 : 21
// Index 4 : 34

?>
