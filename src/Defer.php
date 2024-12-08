<?php

declare(strict_types=1);

// Classe Callback pour gérer les callbacks et leurs arguments.
class Callback
{
    // Le constructeur prend un callable et un tableau d'arguments.
    public function __construct(
        private mixed $cb,  // Le callable à exécuter.
        private array $args = []  // Les arguments à passer au callable.
    ) {}

    // Exécute le callable avec les arguments fournis.
    public function call(): void
    {
        // Appelle le callable avec les arguments via call_user_func_array.
        call_user_func_array($this->cb, $this->args);
    }
}

// Deux exemples de fonctions qui seront utilisées comme callbacks.
function add($a, $b)
{
    echo  $a + $b;
}

function sub($a, $b)
{
    echo $a - $b;
}

// Classe Defer qui gère l'ajout et l'exécution des callbacks.
class Defer 
{
    // Tableau pour stocker les callbacks.
    private array $callableArray = [];

    // Constructeur vide, sans initialisation nécessaire.
    public function __construct()
    {
    }

    // Méthode statique init pour initialiser l'objet avec un callback et ses arguments.
    public static function init(string $callable, array $args = [], Defer &$deferInstance): void
    {
        // Crée une instance de Defer et ajoute un callback via defer().
        $deferInstance = new self();  // Instancie Defer dans la variable passée par référence
        $deferInstance->defer($callable, $args);
    }

    // Méthode magique __invoke pour permettre un appel direct de l'objet comme une fonction.
    public function __invoke(callable $callable, array $args = []): void
    {
        // Ajoute le callback à la pile avec ses arguments.
        $this->defer($callable, $args);
    }

    // Méthode pour ajouter un callback à la pile.
    public function defer(callable $callable, array $args = []): void
    {
        // Crée un objet Callback et l'ajoute à la pile.
        $callback = new Callback($callable, $args);
        $this->callableArray[] = $callback;  // Utilisation de [] au lieu de array_push().
    }

    // Destructeur appelé lorsque l'objet est détruit, exécutant tous les callbacks dans l'ordre inverse.
    public function __destruct()
    {
        // Parcours de la pile des callbacks dans l'ordre inverse (LIFO).
        for ($i = count($this->callableArray) - 1; $i >= 0; $i--) {
            // Exécution de chaque callback.
            $this->callableArray[$i]->call();
        }
    }
}

