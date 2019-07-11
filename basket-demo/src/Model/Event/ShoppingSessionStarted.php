<?php

declare(strict_types=1);

namespace App\Basket\Model\Event;

use App\Basket\Model\Basket\BasketId;
use App\Basket\Model\Basket\ShoppingSession;
use Prooph\EventSourcing\AggregateChanged;

class ShoppingSessionStarted extends AggregateChanged
{
    public function basketId(): BasketId
    {
        return BasketId::fromString($this->aggregateId());
    }

    public function shoppingSession(): ShoppingSession
    {
        return ShoppingSession::fromString($this->payload['shopping_session']);
    }


}