<?php

declare(strict_types=1);

namespace App\BasketTest;

use Prooph\EventSourcing\Aggregate\AggregateType;
use Prooph\EventSourcing\AggregateRoot;
use Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator;

class TestCase extends  \PHPUnit\Framework\TestCase
{
    private $aggregateTranslator;

    protected function popRecordedEvents(AggregateRoot $aggregateRoot)
    {
        return $this->getAggregateTranslator()->extractPendingStreamEvents($aggregateRoot);
    }

    protected function reconstituteAggregateFromHistory(string $aggregateRootClass, array $events)
    {
        return $this->getAggregateTranslator()->reconstituteAggregateFromHistory(
            AggregateType::fromAggregateRootClass($aggregateRootClass),
            new \ArrayIterator($events)
        );
    }


    private function getAggregateTranslator(): AggregateTranslator
    {
        if (null === $this->aggregateTranslator) {
            $this->aggregateTranslator = new AggregateTranslator();
        }
        return $this->aggregateTranslator;
    }
}