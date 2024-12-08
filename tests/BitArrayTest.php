<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use Solo312\BitArray;

class BitArrayTest extends TestCase
{





    // offsetSet test

    public function testOffsetSet()
    {
        $bitArray = new BitArray();
        $bitArray->offsetSet(2, 1);

        $this->assertEquals($bitArray->getBits(), [0, 0, 1]);
    }
    // Test de la méthode count
    public function testCount()
    {
        $bitArray = new BitArray();
        $bitArray->offsetSet(3, 1);

        $this->assertEquals(count($bitArray->getBits()), 4);
    }
    public function testfromString()
    {
        $bitArray = BitArray::fromString("0b001100");
        $this->assertEquals($bitArray->getBits(), [0, 0, 1, 1, 0, 0]);
    }

    public function testFromInt(): void
    {
        // Step 1: Convert an integer to a BitArray
        $integer = 37; // Binary representation: 100101
        $bitArray = BitArray::fromInt($integer);

        // Step 2: Verify the bits in the BitArray
        $expectedBits = [1, 0, 0, 1, 0, 1]; // Expected bit array for 37
        $this->assertEquals($expectedBits, $bitArray->getBits(), "The bits in the BitArray do not match the binary representation of the integer.");
    }




    public function testSet()
    {
        $bit = new BitArray();
        $bit->offsetSet(3, 1);
        $bit->set([1, 1], 1);
        $this->assertEquals([0, 1, 1, 1], $bit->getBits());
    }


    public function testUnSet()
    {
        $bit = new BitArray();
        $bit->setBits([1, 1, 1, 1, 1]);
        $bit->unset(1, 2);
        $this->assertEquals([1, 0, 0, 1, 1], $bit->getBits());
    }
    public function testSlice()
    {
        $bit = new BitArray();
        $bit->setBits([1, 1, 1, 0, 1]);
        $sliceArray = $bit->slice(1, 2);
        $this->assertEquals($sliceArray->getBits(), [1, 1]);
    }

    public function testString()
    {
        $bit = new BitArray();
        $bit->setBits([1, 1, 1, 0, 1]);
        $BitsString = $bit->__toString();
        $this->assertEquals($BitsString, "0b10111");
    }
}
