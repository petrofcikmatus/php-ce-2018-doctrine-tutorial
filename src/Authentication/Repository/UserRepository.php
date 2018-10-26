<?php

namespace Authentication\Repository;

use Authentication\Entity\User;
use Authentication\Storage\UserStorage;

class UserRepository implements UserRepositoryInterface
{
    /** @var UserStorage */
    private $storage;

    public function __construct()
    {
        $this->storage = new UserStorage();
    }

    public function get(string $emailAddress): User
    {
        $user = $this->find($emailAddress);

        if ($user instanceof User) {
            return $user;
        }

        throw new \Exception(sprintf('No user found with email "%s".', $emailAddress));
    }

    public function find(string $emailAddress): ?User
    {
        $serializedUsers = $this->storage->getUsers();

        $users = [];
        foreach ($serializedUsers as $serializedUser) {
            $users[] = User::createFromSerializedString($serializedUser);
        }

        foreach ($users as $user) {
            if ($user->getEmail() === $emailAddress) {
                return $user;
            }
        }

        return null;
    }

    public function store(User $user): void
    {
        if ($this->find($user->getEmail()) === null) {
            $this->storage->addUser($user->serialize());
        }
    }
}
