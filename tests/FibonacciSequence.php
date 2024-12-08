<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class FibonacciSequenceTest extends TestCase
{
    // Test de la méthode `first`
    public function testFirst()
    {
        $fibonacci = FibonacciSequence::first(5); // Première séquence de 5 termes
        
        $expected = [0, 1, 1, 2, 3];  // La séquence attendue
        $actual = iterator_to_array($fibonacci);

        $this->assertEquals($expected, $actual);  // Vérifie que la séquence générée est correcte
    }

    // Test de la méthode `range`
    public function testRange()
    {
        $fibonacci = FibonacciSequence::range(5, 5); // Commence à l'index 5 et prend 5 termes
        
        $expected = [5, 8, 13, 21, 34];  // La séquence attendue à partir de l'index 5
        $actual = iterator_to_array($fibonacci);

        $this->assertEquals($expected, $actual);  // Vérifie que la séquence générée est correcte
    }

    // Test de la méthode `range` avec une plage différente
    public function testRangeWithDifferentStart()
    {
        $fibonacci = FibonacciSequence::range(10, 5); // Commence à l'index 10 et prend 5 termes
        
        $expected = [55, 89, 144, 233, 377];  // La séquence attendue à partir de l'index 10
        $actual = iterator_to_array($fibonacci);

        $this->assertEquals($expected, $actual);  // Vérifie que la séquence générée est correcte
    }

    // Test de la méthode `first` pour un nombre plus élevé
    public function testFirstWithLargerNumber()
    {
        $fibonacci = FibonacciSequence::first(10); // Premiers 10 termes de la séquence
        
        $expected = [0, 1, 1, 2, 3, 5, 8, 13, 21, 34];  // La séquence attendue pour les 10 premiers termes
        $actual = iterator_to_array($fibonacci);

        $this->assertEquals($expected, $actual);  // Vérifie que la séquence générée est correcte
    }
}
