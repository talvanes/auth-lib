<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class AuthContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given there are users:
     */
    public function thereAreUsers(TableNode $table)
    {
        throw new PendingException();
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
     * @Then User should see :arg1
     */
    public function userShouldSee($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given User typed username :arg1
     */
    public function userTypedUsername($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given User typed password :arg1
     */
    public function userTypedPassword($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then User shuold see :arg1
     */
    public function userShuoldSee($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given User :arg1 signed in with password :arg2
     */
    public function userSignedInWithPassword($arg1, $arg2)
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
