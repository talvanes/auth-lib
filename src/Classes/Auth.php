<?php namespace AuthLib\Classes;

use AuthLib\Models\User;
use AuthLib\Traits\HasMessages;

final class Auth
{
    use HasMessages;

    private $username;
    private $password;
    private $userId;

    private $db;


    /**
     * Auth constructor.
     * It receives a PDO connection by dependency injection in order to connect to the users table afterwards.
     *
     * @public
     * @param \PDO $db Database connection (PDO)
     */
    public function __construct(\PDO $db) {
        $this->db = $db;
    }

    /**
     * Sets auth username.
     *
     * @param $string $username [[Description]]
     * @return $this
     */
    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    /**
     * Sets auth password. It must be in plain form, that is, unencrypted.
     *
     * @param string $password [[Description]]
     * @return $this
     */
    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }

    /**
     * Sets auth credentials. Both username and password may be supplied at once.
     *
     * @param  array $credentials
     * @return $this
     */
    public function setCredentials(array $credentials) {
        // username
        if (isset($credentials['username'])) {
            $this->setUsername($credentials['username']);
        }

        // password
        if (isset($credentials['password'])) {
            $this->setPassword($credentials['password']);
        }

        return $this;
    }

    /**
     * This function signs user in if login succeeds, otherwise returns FALSE.
     *
     * @return boolean
     */
    public function login() {
        // if user has not supplied either username or password, deny access
        if (!isset($this->username) || !isset($this->password)) {
            $this->message = "You must type both username and password";
            return false;
        }

        // look for user id by looking under users table on the database
        $selectStmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $selectStmt->execute(['username' => $this->username]);
        $user = $selectStmt->fetch(\PDO::FETCH_OBJ);
        if (!$user) {
            $this->message = "This username does not exist";
            return false;
        }

        // check user's password
        $password = $this->password;
        $passwordHash = $user->password;
        if (password_verify($password, $user->password)) {
            // passwords do match //
            # set up user session #
            $this->userId = $user->id;
            $_SESSION['user_id'] = $this->userId;

            # throw message to user #
            $this->message = "User '{$user->name}' signed in successfully";
            return true;
        }

        // passwords do not match //
        $this->message = "Username and password given do not match";
        return false;
    }
}
