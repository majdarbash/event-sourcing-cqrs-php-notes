<?php

declare(strict_types=1);

namespace App\Basket\Model\Exception;

class ProductAddedTwice extends \Exception
{
    public static function toBasket($basketId, $productId)
    {
        return new self(sprintf(
            'Product %s added twice to basket %s',
            $productId->toString(),
            $basketId->toString()
        ));
    }

}