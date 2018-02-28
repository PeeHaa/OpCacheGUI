<?php

echo 'WARNING: Password will be visible on the command line and will be stored in your history.' . PHP_EOL;
echo 'Don\'t use this script if other people have access to your shell (history)!' . PHP_EOL . PHP_EOL;

echo 'Enter your password: ';

$password = trim(fgets(STDIN));

if (empty($password)) {
    echo 'ERROR: Password empty...';
    exit;
}

echo password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]) . PHP_EOL;
