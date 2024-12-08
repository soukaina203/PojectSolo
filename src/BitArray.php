<?php

declare(strict_types=1);
namespace Solo312;

use Iterator;
use ArrayAccess;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use Stringable;
// Iterator implementation for iterating through BitArray
class BitArrayIterator implements Iterator
{
    public array $array = []; // Holds the array to iterate over
    private int $index = 0; // Tracks the current position in the array
    // Constructor initializes the iterator with the provided array
    public function __construct(array $array)
    {
        $this->array = $array;
    }

    // Retu                                                                                              rns the current element in the array
    public function current(): mixed 
    {
        return $this->array[$this->index];
        
    }

    // Returns the current index in the array
    public function key(): int
    {
        return $this->index;
    }

    // Moves to the next element in the array
    public function next(): void
    {
        $this->index += 1;
    }

    // Resets the index to the start of the array
    public function rewind(): void
    {
        $this->index = 0;
    }

    // Checks if the current index is valid
    public function valid(): bool
    {
        return $this->index < count($this->array);
    }
}

// Implementation of the BitArray class
class BitArray implements  ArrayAccess, Countable, IteratorAggregate, Stringable
{
    private $bits = []; // Array to hold the bits
    private const BYTE_SIZE = 8; // Byte size for internal operations
    private const INT_SIZE = PHP_INT_SIZE * self::BYTE_SIZE; // Integer size in bits

    // Handles setting a bit at a specific index
    public function offsetSet(mixed $offset, mixed $value): void
    {
        // If the offset is larger than the current array, fill with zeros
        if (count($this->bits) < $offset) {
            for ($i = count($this->bits); $i < $offset; $i++) {
                $this->bits[$i] = 0;
            }
        }
        $this->bits[$offset] = $value; // Set the value at the given offset
    }
    public function getBits():array  {
        return $this->bits;
    }
    public function setBits(array $value):array  {
         $this->bits=$value;
         return $this->bits;
    }
    // Converts a binary string into a BitArray
    public static function fromString(string $from)
    {
        // Remove the "0b" prefix if it exists
        if (substr($from, 0, 2) === '0b') {
            $from = substr($from, 2);
        }

        // Validate that the string contains only binary characters
        if (!preg_match('/^[01]+$/', $from)) {
            throw new InvalidArgumentException("The string must only contain '0' or '1'.");
        }

        $bitArray = new self();
        $bitArray->bits = str_split($from); // Convert the string into an array of bits

        return $bitArray;
    }

    // Constructor
    public function __construct()
    {
        // Initialize with an empty array by default
    }

    // Converts an integer to a BitArray
    public static function fromInt(int $from)
    {
        $binaryString = decbin($from); // Convert the integer to a binary string
        $bitArray=self::fromString($binaryString); // Use fromString to create a BitArray
        return $bitArray;
    }

    // Slices a portion of the BitArray
    public function slice(int $start = 0, int $length = -1): self
    {
        $slicedArray = new self();
        $new_array = [];

        // If length is negative, slice from the start index to the end
        if ($length < 0) {
            for ($i = $start; $i < count($this->bits); $i++) {
                $new_array[] = $this->bits[$i];
            }
        }

        // If length is positive, slice from the start index to start + length
        if ($length > 0) {
            for ($i = $start; $i < $length + $start; $i++) {
                if (isset($this->bits[$i])) { // Avoid undefined index errors
                    $new_array[] = $this->bits[$i];
                }
            }
        }

        $slicedArray->bits = $new_array; // Assign the sliced portion
        return $slicedArray;
    }

    // Sets a range of bits starting from a specific index
    public function set(array $bits, int $start = 0): void
    {
        if (empty($bits)) {
            return;
        }

        $y = 0; // Counter for the input bits
        $currentLength = count($this->bits);

        // Ensure space in the bits array by filling with zeros
        for ($i = $currentLength; $i <= $start + count($bits) - 1; $i++) {
            $this->offsetSet($i, 0);
        }

        // Assign the bits from the input array
        for ($i = $start; $i < $start + count($bits); $i++) {
            $this->bits[$i] = $bits[$y];
            $y++;
        }
    }

    // Unsets (sets to zero) a range of bits starting from a specific index
    public function unset(int $start, int $length = -1): void
    {
        if ($length < 0) {
            // Unset from start to the end
            for ($i = $start; $i < count($this->bits); $i++) {
                $this->bits[$i] = 0;
            }
        }

        if ($length > 0) {
            // Unset from start to start + length
            for ($i = $start; $i < $length + $start; $i++) {
                if (isset($this->bits[$i])) {
                    $this->bits[$i] = 0;
                }
            }
        }
    }

    // Checks if a bit exists at a specific index
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->bits[$offset]);
    }

    // Gets the value of a bit at a specific index
    public function offsetGet(mixed $offset): int
    {
        return $this->bits[$offset] ?? 0; // Return 0 if the index does not exist
    }

    // Unsets (sets to zero) a bit at a specific index
    public function offsetUnset(mixed $offset): void
    {
        if (!$this->offsetExists($offset)) {
            return;
        }
        $this->bits[$offset] = 0;
    }

    // Counts the total number of bits
    public function count(): int
    {
        if (empty($this->bits)) {
            return 0;
        }

        $BiggerIndex = max(array_keys($this->bits)); // Find the highest index used
        return $BiggerIndex + 1;
    }

    // Returns an iterator for the BitArray
    public function getIterator(): BitArrayIterator
    {
        return new BitArrayIterator($this->bits);
    }

   // Converts the BitArray into a binary string
   public function __toString(): string
   {
       $reversedBits = array_reverse($this->bits); // Reverse the bits for MSB to LSB order
       $bitString = implode('', $reversedBits); // Join the bits into a single string
       return sprintf('0b%s', $bitString); // Format with '0b' prefix
   }

     // Gets an array of BitArray slices
     public function getSlicesIterator(int $sliceSize): array
     {
         $slices = [];
         $totalBits = count($this->bits);
         
         // Slice the BitArray into smaller parts of size $sliceSize
         for ($i = 0; $i < $totalBits; $i += $sliceSize) {
             // Create a slice of bits
             $slice = array_slice($this->bits, $i, $sliceSize);
 
             // Create a new BitArray instance and directly assign the slice
             $slicedBitArray = new BitArray();
             $slicedBitArray->bits = $slice; // Directly assign the slice
 
             // Add the sliced BitArray to the slices array
             $slices[] = $slicedBitArray;
         }
         return $slices;
     }

}
