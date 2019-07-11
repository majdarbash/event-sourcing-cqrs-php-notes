<?php

declare(strict_types=1);

namespace App\Basket\Model;

use App\Basket\Model\Basket\BasketId;
use App\Basket\Model\Basket\ShoppingSession;
use App\Basket\Model\ERP\ProductId;
use App\Basket\Model\Event\ProductAddedToBasket;
use App\Basket\Model\Event\ShoppingSessionStarted;
use App\Basket\Model\Exception\ProductAddedTwice;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;

class Basket extends AggregateRoot
{

    /** @var BasketId */
    private $basketId;

    private $shoppingSession;

    private $products = [];

    public static function startShoppingSession(
        ShoppingSession $shoppingSession,
        BasketId $basketId
    )
    {
        // starting aggregate lifecycle by creating an "empty" instance
        $self = new self();

        $self->recordThat(ShoppingSessionStarted::occur($basketId->toString(), [
            'shopping_session' => $shoppingSession->toString()
        ]));

        return $self;
    }


    public function addProduct(ProductId $productId): void
    {
        if (array_key_exists($productId->toString(), $this->products)) {
            throw ProductAddedTwice::toBasket($this->basketId, $productId);
        }

        $this->recordThat(ProductAddedToBasket::occur($this->basketId->toString(), [
            'product_id' => $productId->toString()
        ]));
    }

    protected function aggregateId(): string
    {

    }

    protected function apply(AggregateChanged $event): void
    {
        switch ($event->messageName()) {
            case ShoppingSessionStarted::class:
                $this->applyShoppingSessionStarted($event);
                break;
            case ProductAddedToBasket::class:
                $this->applyProductAddedToBasket($event);
                break;
        }
    }

    protected function applyShoppingSessionStarted(ShoppingSessionStarted $event)
    {
        $this->basketId = $event->basketId();
        $this->shoppingSession = $event->shoppingSession();
    }

    protected function applyProductAddedToBasket(ProductAddedToBasket $event)
    {
        $this->products[$event->productId()->toString()] = $event->productId();
    }
}