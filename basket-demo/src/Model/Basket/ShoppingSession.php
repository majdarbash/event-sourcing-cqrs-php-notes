<?php

declare(strict_types=1);

namespace App\Basket\Model\Basket;


final class ShoppingSession
{
    private $shoppingSession;

    /**
     * ShoppingSession constructor.
     * @param $shoppingSession
     */
    public function __construct(string $shoppingSession)
    {
        $this->shoppingSession = $shoppingSession;
    }

    public static function fromString(string $shoppingSession)
    {
        return new self($shoppingSession);
    }

    public function toString()
    {
        return $this->shoppingSession;
    }

    public function equals($other): bool
    {
        return $this->shoppingSession === $other->shoppingSession;
    }

    public function __toString(): string
    {
        return $this->shoppingSession;
    }
}