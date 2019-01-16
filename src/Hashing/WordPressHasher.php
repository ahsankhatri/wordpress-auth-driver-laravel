<?php

namespace MrShan0\WordpressAuth\Hashing;

use Hautelook\Phpass\PasswordHash;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Hashing\AbstractHasher;

class WordPressHasher extends AbstractHasher implements Hasher
{
    protected $hasher;

    public function __construct(PasswordHash $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * Hash the given value.
     *
     * @param  string  $value
     * @param  array   $options
     * @return string
     */
    public function make($value, array $options = array())
    {
        return $this->hasher->HashPassword($value);
    }

    /**
     * Check the given plain value against a hash.
     *
     * @param  string  $value
     * @param  string  $hashedValue
     * @param  array   $options
     * @return bool
     */
    public function check($value, $hashedValue, array $options = array())
    {
        if ( strlen($hashedValue) <= 32 ) {
            return $hashedValue == md5($value);
        }

        $check = $this->hasher->CheckPassword($value, $hashedValue);

        return $check;
    }

    /**
     * Check if the given hash has been hashed using the given options.
     *
     * @param  string  $hashedValue
     * @param  array   $options
     * @return bool
     */
    public function needsRehash($hashedValue, array $options = array())
    {
        return false;
    }
}
