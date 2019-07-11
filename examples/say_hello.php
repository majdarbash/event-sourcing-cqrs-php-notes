<?php

declare(strict_types=1);

namespace Prooph\Tutorial;

use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;

require 'vendor/autoload.php';

final class SayHello extends Command implements PayloadConstructable
{
    use PayloadTrait;

    public function to(): string
    {
        return $this->payload['to'];
    }
}


echo <<<END
Instantiating SayHello class:
* Extends Command
* Command Extends DomainMessage
* DomainMessage assigns uuid() and implements MessageInterface


END;

$sayHello = new SayHello(['to' => 'World']);
echo 'Hello ' . $sayHello->to();


echo "Dumping variables: ";
echo "UUID:";
print_r($sayHello->uuid());

echo "Metadata:";
print_r($sayHello->withAddedMetadata('test', 12));