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

        // Pre-calculate the Fibonacci sequence based on the range
        for ($i = $this->start; $i <= $this->length; $i++) {
            $this->optimizedCalcul($i); // Calculate Fibonacci number for this index
        }
    }

    // Optimized calculation to calculate Fibonacci numbers up to a given index
    private function optimizedCalcul(int $index): void
    {
        // Ensure we calculate Fibonacci numbers up to the requested index
        for ($i = count($this->sequence); $i < $index; $i++) {
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
        return $this->sequence[$this->index];
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
        return new self($start, $length); // Start from given index, calculate 'length' terms
    }
}

// Testing the FibonacciIterator

echo "Fibonacci (first 10 terms):\n";
$fibonacciFirst = FibonacciSequence::first(10);  // First 10 terms
foreach ($fibonacciFirst as $index => $value) {
    echo "Index $index : $value\n";
}

echo "\nFibonacci (range starting at index 5 for 5 terms):\n";
$fibonacciRange = FibonacciSequence::range(5, 5);  // Start at index 5, next 5 terms
foreach ($fibonacciRange as $index => $value) {
    echo "Index $index : $value\n";
}

// $fibonacci = new FibonacciSequence(9);
// $fibonacci->optimizedCalcul(0);
// echo "Index 0 : " . $fibonacci->getSequence()[0] . PHP_EOL;

// // Calcul du deuxième terme
// $fibonacci->optimizedCalcul(1);
// echo "Index 1 : " . $fibonacci->getSequence()[1] . PHP_EOL;

// // Calcul d'un terme plus loin dans la suite
// $fibonacci->optimizedCalcul(12);
// echo "Index 5 : " . $fibonacci->getSequence()[12] . PHP_EOL;

// // Vérifiez l'état complet de la suite après ces calculs
// echo "Suite calculée : " . implode(", ", $fibonacci->getSequence()) . PHP_EOL;
?>

