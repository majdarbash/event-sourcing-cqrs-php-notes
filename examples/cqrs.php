<?php

declare(strict_types=1);

namespace Prooph\Tutorial;
require 'vendor/autoload.php';

require 'include/user_classes.php';

class UserService
{
    private $userRepository;

    /**
     * UserService constructor.
     * @param $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser(int $id, string $name, string $email)
    {
        $user = new User($id);

        $user->setName($name);
        $user->setEmail($email);

        $this->userRepository->save($user);

        return $user;
    }

    public function getUser(int $id)
    {
        $user = $this->userRepository->getById($id);
        return $user;
    }
}


class CreateUserHandler
{
    private $userRepository;

    /**
     * CreateUserHandler constructor.
     * @param $userRepository
     */
    public function __construct($userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createUser(int $id, string $name, string $email): void
    {
        $user = new User($id);

        $user->setName($name);
        $user->setEmail($email);

        $this->userRepository->save($user);
    }
}

class UserFinder
{

    private $userRepository;

    /**
     * UserFinder constructor.
     * @param $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUser(int $id): User
    {
        $user = $this->userRepository->getById($id);
        return $user;
    }
}


$memoryPersistence = new MemoryPersistence();
$userRepository = new UserRepository($memoryPersistence);

echo "Creating the user using the service: \$userService->createUser():\n";
$userService = new UserService($userRepository);
$user = $userService->createUser(12, 'majd', 'info@example.com');
print_r($user);

echo "Retrieving the user using the service: \$userService->getUser():\n";
print_r($userService->getUser(12));

echo "\nIn CQRS Case (Splitting writes from reads)";

echo "\nWrite operations don't have a return value: \$createUserHandler->createUser()";
$createUserHandler = new CreateUserHandler($userRepository);
$createUserHandler->createUser(13, 'majd 13 user', 'majd.arbash@gmail.com');

echo "\nFinding the user using user finder service:\$userFinder->getUser()\n";
$userFinder = new UserFinder($userRepository);
print_r($userFinder->getUser(13));

echo "\nAs reads are separated from writes we can build an optimized UserFinder which connects to database directly\n";
echo "\nand skips ORM - as it's guaranteed that no state change will happen";
echo "\nThe target of the read model is to select the data and return it to the user as fast as possible.\n\n";