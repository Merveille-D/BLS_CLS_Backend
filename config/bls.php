<?php
$defaultEncryptedLimit = 'eyJpdiI6Im9YRUZleXNvaXpZOUlJNGFibVcwY0E9PSIsInZhbHVlIjoiYjY1V3JKZ3F3N3JmNUpFUDA2MGNMdz09IiwibWFjIjoiYTY2MTEzNmQ3MWJjMDQ1ZTYzZDUyYzZjZTgzZWQ5M2MxYjBiZDIyOWRjMTgzOTUzZDNhOGFhNzM2OGNmOWMzOCIsInRhZyI6IiJ9';

return [
    'countries' => [
        'limit' => env('COUNTRY_LIMIT') ? encrypt(env('COUNTRY_LIMIT')) : $defaultEncryptedLimit,
    ],
];
