<?php namespace AuthLib\Classes;

use AuthLib\Models\User;

class Auth
{
    protected $user;

    /**
     * Sets user's credentials (username and password) for authentication
     *
     * @param  array $credentials
     * @return $this
     */
    public function setCredentials(array $credentials) {
        $this->setUsername($credentials['username']);
        $this->setPassword($credentials['password']);

        return $this;
    }


    public function __call($method, $arguments) {
        // does this method belong to this class? if so, just call it
        if (method_exists($this, $method)) {
            call_user_func_array([$this, $method], $arguments);
        }

        // otherwise call methods from the User model
        call_user_func_array([$this->user, $method], $arguments);
    }


}
