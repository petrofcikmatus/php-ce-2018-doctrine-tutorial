<?php

// registering a new user:

// 1. check if a user with the same email address exists
// 2. if not, create a user
// 3. hash the password
// 4. send the email to confirm activation (we will just display it)
// 5. save the user

// Tip: discuss - email or saving? Chicken-egg problem

require_once __DIR__ . '/../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit('Not a post request');
}

if (empty($_POST['emailAddress']) || empty($_POST['password'])) {
    exit('Meh, there is not emailAddress or password.');
}

$repository = new \Authentication\Repository\UserRepository();

$user = $repository->find($_POST['emailAddress']);

if ($user !== null) {
    exit('User already exists.');
}

$user = \Authentication\Entity\User::createFromForm($_POST['emailAddress'], $_POST['password']);

$repository->store($user);

exit('OK');
