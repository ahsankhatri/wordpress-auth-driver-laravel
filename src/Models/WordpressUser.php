<?php

namespace MrShan0\WordpressAuth\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class WordpressUser extends Authenticatable
{
    use Notifiable;

    /**
     * Explicitly define your table name
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Disable timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Define primary key
     *
     * @var string
     */
    protected $primaryKey = 'ID';

    /**
     * The column name of the "remember me" token.
     *
     * @var string
     */
    protected $rememberTokenName = false;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'user_registered',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_pass',
        'remember_token', // disabled via protected property
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_login',
        'user_pass',
        'user_nicename',
        'user_email',
        'user_url',
        'user_registered',
        'user_activation_key',
        'user_status',
        'display_name',
    ];

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Set connection via config explicitly.
        $this->setConnection(config('wordpress-auth.connection', 'mysql'));
    }

    /**
     * Accessor to update password via Auth scaffolding
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes[$this->getPasswordColumnKey()] = $value;
    }

    /**
     * Return the key used for email in wordpress schema
     *
     * @return string
     */
    public function getEmailColumnKey()
    {
        return config('wordpress-auth.options.email_column', 'user_email');
    }

    /**
     * Return the key used for password in wordpress schema
     *
     * @return string
     */
    public function getPasswordColumnKey()
    {
        return config('wordpress-auth.options.password_column', 'user_pass');
    }

    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->{$this->getEmailColumnKey()};
    }

    /**
     * Return password value
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->{$this->getPasswordColumnKey()};
    }

    /**
     * Usage for notifiable for email
     *
     * @return string
     */
    public function routeNotificationForMail()
    {
        return $this->getEmailForPasswordReset();
    }
}
