<?php namespace AuthLib\Models;

class User
{
    protected $id;
    protected $username;
    protected $password;
    protected $name;

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
     * Sets user's password. It must be plain so it is encrypted for db storage.
     *
     * @param  string $password
     * @return $this
     */
    public function setPassword($password) {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
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
