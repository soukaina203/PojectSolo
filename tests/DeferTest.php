<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

// On suppose que la classe Defer et les autres classes sont déjà incluses.

class DeferTest extends TestCase
{
    // Test de l'initialisation d'un Defer avec la méthode init
    public function testInitWithCallback(): void
    {
        $defer = null; // Variable pour l'instance de Defer

        // Initialisation de Defer avec un callback 'add' et ses arguments.
        Defer::init('add', [1, 2], $defer);

        // Utilisation de __invoke pour ajouter un autre callback 'sub' et ses arguments.
        $defer('sub', [5, 3]);

        // Le destructeur de Defer va exécuter les callbacks dans l'ordre inverse (LIFO).
        // Attendre que la sortie soit capturée
        $this->expectOutputString("3-2");
    }

    // Test avec des callbacks supplémentaires et un ordre d'exécution.
    public function testDeferCallbacksOrder(): void
    {
        $defer = null;

        // Initialisation de l'objet Defer avec un callback 'add'
        Defer::init('add', [10, 5], $defer);
        
        // Ajout de plusieurs autres callbacks via __invoke()
        $defer('sub', [7, 3]);
        $defer('add', [1, 2]);

        // Attendre que la sortie soit capturée
        $this->expectOutputString("5-4");
    }

    // Test de l'appel du callback dans le bon ordre (LIFO).
    public function testDeferWithMultipleCallbacks(): void
    {
        $defer = null;

        // Initialisation de l'objet Defer avec un callback 'add'
        Defer::init('add', [10, 2], $defer);
        
        // Ajout de quelques autres callbacks
        $defer('sub', [5, 3]);  // 'sub' doit être exécuté en premier
        $defer('add', [1, 2]);   // 'add' doit être exécuté ensuite

        // Attendre que la sortie soit capturée
        $this->expectOutputString("2+3");
    }

    // Test de l'instanciation d'un Defer vide.
    public function testEmptyDefer(): void
    {
        $defer = new Defer();

        // Aucun callback ajouté, donc rien ne devrait être exécuté.
        // Nous nous assurons que la sortie est vide.
        $this->expectOutputString('');
    }
}
