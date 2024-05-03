<?php

use services\Database;

$validators = [
    'dvd' => 'DVDValidator',
    'book' => 'BookValidator',
    'furniture' => 'FurnitureValidator',
    'none' => 'NoneValidator'
];

$type = ''; // take from response

$validatorClass = $validators[$type];
$validator = new $validatorClass();