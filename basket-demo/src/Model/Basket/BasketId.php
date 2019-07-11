<?php

declare(strict_types=1);

namespace App\Basket\Model\Basket;

class BasketId
{
    private $basketId;

    /**
     * BasketId constructor.
     * @param $basketId
     */
    public function __construct(string $basketId)
    {
        $this->basketId = $basketId;
    }


    public static function fromString(string $basketId): self
    {
        return new self($basketId);
    }

    public function toString(): string
    {
        return $this->basketId;
    }

    public function equals($other): bool
    {
        if (!$other instanceof self) {
            return false;
        }

        return $this->basketId === $other->basketId;
    }

    public function __toString(): string
    {
        return $this->basketId;
    }
}