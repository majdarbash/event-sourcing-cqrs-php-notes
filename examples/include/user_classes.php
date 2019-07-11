<?php

declare(strict_types=1);

namespace Prooph\Tutorial;


interface PersistenceInterface
{
    public function persist($id, $data);

    public function retrieve($id);

    public function delete($id);
}

class MemoryPersistence implements PersistenceInterface
{

    private $database;

    public function persist($id, $data)
    {
        $this->database[$id] = $data;
    }

    public function retrieve($id)
    {
        return $this->database[$id];
    }

    public function delete($id)
    {
        unset($this->database[$id]);
    }

    public function getAllRecords(){
        return $this->database;
    }
}

class UserRepository
{

    private $persistence;

    /**
     * UserRepository constructor.
     * @param $persistence
     */
    public function __construct(PersistenceInterface $persistence)
    {
        $this->persistence = $persistence;
    }


    public function save(User $user)
    {
        $this->persistence->persist($user->getId(), [
            'name' => $user->getName(),
            'email' => $user->getEmail()
        ]);
    }

    public function getById($id)
    {
        $data = $this->persistence->retrieve($id);
        $user = new User($id);
        $user->setName($data['name']);
        $user->setEmail($data['email']);

        return $user;
    }
}

class User
{
    private $id;
    private $name;
    private $email;

    /**
     * User constructor.
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}
