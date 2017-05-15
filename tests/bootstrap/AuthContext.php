<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Hook\Scope\AfterScenarioScope;

/**
 * Defines application features from the specific context.
 */
class AuthContext implements Context
{
    protected $db;
    protected $auth;

    /**
     * * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     *
     * @public
     * @param string $dsn                 DB DSN
     * @param string [$username = 'root'] DB username (default: root)
     * @param string [$password = '']     DB password (default: '')
     */
    public function __construct($dsn, $username = 'root', $password = '')
    {
        // set up database connection
        $this->db = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }

    /**
     * Destructor.
     *
     * As it ends the context, it shuts down database connection
     * @public
     */
    public function __destruct()
    {
        // kill database connection
        $this->db = null;
    }


    /**
     * @BeforeScenario
     */
    public function beginTrans(BeforeScenarioScope $scope)
    {
        $this->db->beginTransaction();
    }

    /**
     * @AfterScenario
     */
    public function rollbackTrans(AfterScenarioScope $scope)
    {
        $this->db->rollBack();
    }


    /**
     * @Given there are users:
     */
    public function thereAreUsers(TableNode $usersTable)
    {
        // prepare PDO statement for insert query
        $insertStmt = $this->db->prepare("INSERT INTO users (username, password, name) VALUES (:username, :password, :name)");

        // insert records into database
        foreach ($usersTable as $userData) {
            $insertStmt->execute([
                'username' => $userData['username'],
                'password' => password_hash($userData['password'], PASSWORD_BCRYPT),
                'name' => $userData['name'],
            ]);
        }
    }

    /**
     * @Given User typed no username
     */
    public function userTypedNoUsername()
    {
        throw new PendingException();
    }

    /**
     * @When User attempts to sign in
     */
    public function userAttemptsToSignIn()
    {
        throw new PendingException();
    }

    /**
     * @Then User should see :message
     */
    public function userShouldSee($message)
    {
        throw new PendingException();
    }

    /**
     * @Given User typed username :username
     */
    public function userTypedUsername($username)
    {
        throw new PendingException();
    }

    /**
     * @Given User typed password :password
     */
    public function userTypedPassword($password)
    {
        throw new PendingException();
    }

    /**
     * @Given User :username has signed in with password :password
     */
    public function userSignedInWithPassword($username, $password)
    {
        throw new PendingException();
    }

    /**
     * @When User attempts to sign out
     */
    public function userAttemptsToSignOut()
    {
        throw new PendingException();
    }
}
