<?php namespace AuthLib\Models;

class User
{
    protected $username;
    protected $password;
    protected $name;
    private $plain_pass;

    /**
     * Sets user's login
     *
     * @param  string $username
     * @return $this
     */
    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    /**
     * Sets user's password
     *
     * @param  string $password
     * @return $this
     */
    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
        $this->plain_pass = $password;
        return $this;
    }

    /**
     * Sets user's full name
     *
     * @param  string $name
     * @return $this
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }


    /**
     * Gets user's login
     *
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Gets user's full name
     * @return string
     */
    public function getName() {
        return $this->name;
    }
}
