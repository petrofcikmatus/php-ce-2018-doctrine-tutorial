<?php

namespace App;

// registering a new user:

// 1. check if a user with the same email address exists
// 2. if not, create a user
// 3. hash the password
// 4. send the email to confirm activation (we will just display it)
// 5. save the user

// Tip: discuss - email or saving? Chicken-egg problem

use Authentication\Entity\User;
use Authentication\Repository\UserRepository;
use Authentication\Value\Email;
use Authentication\Value\Password;

require_once __DIR__ . '/../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit('Not a post request');
}

if (empty($_POST['emailAddress']) || empty($_POST['password'])) {
    exit('Meh, there is not emailAddress or password.');
}

$repository = new UserRepository();

$user = $repository->find($_POST['emailAddress']);

if ($user !== null) {
    exit('User already exists.');
}

$email = Email::fromString($_POST['emailAddress']);
$password = Password::fromString($_POST['password']);
$passwordHash = $password->makeHash();

$user = new User($email, $passwordHash);

$repository->store($user);

exit('OK');
