<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Assert\Assert;

use AuthLib\Classes\Auth;

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
        $this->db = new \PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);

        // initializing authentication
        $this->auth = new Auth($this->db);
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
     * @AfterScenario @session
     */
    public function cleanSession(AfterScenarioScope $scope)
    {
        if (isset($_SESSION['user_id'])) unset($_SESSION['user_id']);
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
        $this->auth->setUsername(null);
    }

    /**
     * @When User attempts to sign in
     */
    public function userAttemptsToSignIn()
    {
        $this->auth->login();
    }

    /**
     * @Then User should see :message
     */
    public function userShouldSee($message)
    {
        $response_msg = $this->auth->getMessage();
        Assert::that($response_msg)->same($message);
    }

    /**
     * @Given User typed username :username
     */
    public function userTypedUsername($username)
    {
        $this->auth->setUsername($username);
    }

    /**
     * @Given User typed password :password
     */
    public function userTypedPassword($password)
    {
        $this->auth->setPassword($password);
    }

    /**
     * @Given User :username has signed in with password :plainPassword
     */
    public function userSignedInWithPassword($username, $plainPassword)
    {
        $this->auth->setCredentials([
            'username' => $username,
            'password' => $plainPassword,
        ])->login();
    }

    /**
     * @When User attempts to sign out
     */
    public function userAttemptsToSignOut()
    {
        $this->auth->logout();
    }
}
