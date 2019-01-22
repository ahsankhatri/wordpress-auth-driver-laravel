<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Seperate Database Connection
    |--------------------------------------------------------------------------
    |
    | You can define your own connection other than the default one in
    | database.php to use multiple connections/database in one.
    |
    */
    'connection' => 'mysql',

    /*
    |--------------------------------------------------------------------------
    | Password hashing configuration for Wordpress authentication
    |--------------------------------------------------------------------------
    */
    'hash' => [

        /*
        |--------------------------------------------------------------------------
        | Iteration Count
        |--------------------------------------------------------------------------
        |
        | The number of iterations used to hash the password.
        | Minimum: 4, Maximum: 31
        |
        */
        'iteration_count' => 8,


        /*
        |--------------------------------------------------------------------------
        | Portable Hashes
        |--------------------------------------------------------------------------
        |
        | Should we generate portable hashes? true or false
        |
        */
        'portable_hashes' => true,

    ]

];
