<?php

use PHPUnit\Framework\TestCase;

class BitArrayTest extends TestCase
{
    // Test de la méthode fromString
    public function testFromString()
    {
        $bitArray = BitArray::fromString("0b1010010111110000");
        $this->assertInstanceOf(BitArray::class, $bitArray);
        $this->assertEquals("0b1010010111110000", (string)$bitArray);
    }

    // Test de la méthode fromInt
    public function testFromInt()
    {
        $bitArray = BitArray::fromInt(4368);  // 4368 => "0b1010010111110000"
        $this->assertInstanceOf(BitArray::class, $bitArray);
        $this->assertEquals("0b1010010111110000", (string)$bitArray);
    }

    // Test de l'accès et de la modification via ArrayAccess
    public function testArrayAccess()
    {
        $bitArray = new BitArray();
        $bitArray[0] = 1; // Définir le bit à l'index 0
        $bitArray[3] = 1; // Définir le bit à l'index 3
        $this->assertEquals(1, $bitArray[0]); // Vérifier le bit à l'index 0
        $this->assertEquals(0, $bitArray[1]); // Vérifier le bit à l'index 1
        $this->assertEquals(1, $bitArray[3]); // Vérifier le bit à l'index 3
    }

    // Test de la méthode slice
    public function testSlice()
    {
        $bitArray = BitArray::fromString("0b1010010111110000");
        $slicedArray = $bitArray->slice(4, 4);  // Découpe de 4 à 8 bits => "1010"
        $this->assertEquals("0b1010", (string)$slicedArray); // Vérifier la tranche
    }

    // Test de la méthode set
    public function testSet()
    {
        $bitArray = new BitArray();
        $bitArray->set([1, 0, 1, 1], 0);  // Définir 1, 0, 1, 1 à partir de l'index 0
        $this->assertEquals(1, $bitArray[0]);
        $this->assertEquals(0, $bitArray[1]);
        $this->assertEquals(1, $bitArray[2]);
        $this->assertEquals(1, $bitArray[3]);
    }

    // Test de la méthode unset
    public function testUnset()
    {
        $bitArray = new BitArray();
        $bitArray->set([1, 1, 0, 1], 0);  // Définir 1, 1, 0, 1 à partir de l'index 0
        $bitArray->unset(1, 2);  // Unset (mettre à zéro) les indices 1 et 2
        $this->assertEquals(1, $bitArray[0]);
        $this->assertEquals(0, $bitArray[1]);
        $this->assertEquals(0, $bitArray[2]);
        $this->assertEquals(1, $bitArray[3]);
    }

    // Test de la méthode __toString pour la représentation binaire
    public function testToString()
    {
        $bitArray = BitArray::fromString("0b1010010111110000");
        $this->assertEquals("0b1010010111110000", (string)$bitArray);
    }

    // Test de l'itérateur
    public function testIterator()
    {
        $bitArray = BitArray::fromString("0b1011");
        $bits = [];
        foreach ($bitArray as $bit) {
            $bits[] = $bit;
        }
        $this->assertCount(4, $bits);  // La taille de l'array est 4
        $this->assertEquals([1, 0, 1, 1], $bits);  // Vérifier que les valeurs sont correctes
    }

    // Test de la méthode getSlicesIterator
    public function testGetSlicesIterator()
    {
        $bitArray = BitArray::fromString("0b1010010111110000");
        $slices = $bitArray->getSlicesIterator(8);  // Découpe en tranches de 8 bits
        $this->assertCount(2, $slices);  // Il devrait y avoir 2 tranches
        $this->assertEquals("0b10100101", (string)$slices[0]);
        $this->assertEquals("0b11110000", (string)$slices[1]);
    }

    // Test de la méthode offsetUnset
    public function testOffsetUnset()
    {
        $bitArray = BitArray::fromString("0b101011");
        unset($bitArray[1]);
        $this->assertEquals(0, $bitArray[1]); // Vérifier que le bit à l'index 1 est maintenant 0
    }
}
