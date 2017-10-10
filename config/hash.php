<?php

/**
 * Configuration for WordPress Hashing
 */

return array(

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

);

?>
