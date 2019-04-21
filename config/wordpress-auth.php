<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Separate Database Connection
    |--------------------------------------------------------------------------
    |
    | You can define your own connection other than the default one in
    | database.php to use multiple connections/database in one.
    |
    */
    'connection' => 'wp-mysql',

    /*
    |--------------------------------------------------------------------------
    | WordPress Customized Options
    |--------------------------------------------------------------------------
    |
    | Due to any reason if you plan to change your wordpress schema or
    | make usage of any additional column cab be defined here.
    |
    */
    'options' => [

        /*
        |--------------------------------------------------------------------------
        | WP Column Mapping
        |--------------------------------------------------------------------------
        |
        | Following option will help laravel auth scaffolding to work with
        | wordpress default (or customizeable) column names
        |
        */
        'force_wp_email' => true,
        'force_wp_password' => true,

        /*
        |--------------------------------------------------------------------------
        | WP Email Column
        |--------------------------------------------------------------------------
        |
        | If you're using any other column name other than default `user_email`
        |
        */
       'email_column' => 'user_email',

        /*
        |--------------------------------------------------------------------------
        | WP Password Column
        |--------------------------------------------------------------------------
        |
        | If you're using any other column name other than default `user_pass`
        |
        */
       'password_column' => 'user_pass',

    ],

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
