<?php


namespace App\Basket\Model\Event;


use App\Basket\Model\Basket\BasketId;
use App\Basket\Model\ERP\ProductId;
use Prooph\EventSourcing\AggregateChanged;

class ProductAddedToBasket extends AggregateChanged
{

    public function basketId(): BasketId
    {
        return BasketId::fromString($this->aggregateId());
    }

    public function productId(): ProductId
    {
        return ProductId::fromString($this->payload()['product_id']);
    }
}