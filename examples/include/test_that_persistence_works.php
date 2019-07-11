<?php

declare(strict_types=1);

namespace Prooph\Tutorial;
require '../vendor/autoload.php';

require 'user_classes.php';

$memoryPersistence = new MemoryPersistence();
$userRepository = new UserRepository($memoryPersistence);

$user = new User(12);
$user->setName('Majd');
$user->setEmail('test@example.com');

$userRepository->save($user);

echo "Data is in the database";
print_r($userRepository->getById(12));
print_r($memoryPersistence->getAllRecords());