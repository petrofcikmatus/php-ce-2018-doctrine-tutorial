<?php

namespace Authentication\Storage;

class UserStorage
{
    private $usersFileName = __DIR__ . 'users.txt';

    public function __construct()
    {
        if (file_exists($this->usersFileName)) {
            return;
        }

        file_put_contents($this->usersFileName, serialize([]));
    }

    public function getUsers(): array
    {
        return unserialize(file_get_contents($this->usersFileName));
    }

    public function addUser(string $user): void
    {
        $users = $this->getUsers();
        $users[] = $user;

        file_put_contents($this->usersFileName, serialize($users));
    }
}
