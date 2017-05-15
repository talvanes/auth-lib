
  Feature: User Authentication

  Background:
    Given there are users:
     | username | password | name     |
     | talba    | 123456   | Talvanes |

    Scenario: User did not type either username or password
      Given User typed no username
      When User attempts to sign in
      Then User should see "You must type both username and password"

    Scenario: Username does not exist
      Given User typed username "foo"
      When User attempts to sign in
      Then User should see "This username does not exist"

    Scenario: Username and password given do not match
      Given User typed username "talba"
        And User typed password "654321"
      When User attempts to sign in
      Then User should see "Username and password given do not match"

    Scenario: Username and password match
      Given User typed username "talba"
        And User typed password "123456"
      When User attempts to sign in
      Then User should see "User 'Talvanes' signed in successfully"

    Scenario: User signs out
      Given User "talba" has signed in with password "123456"
      When User attempts to sign out
      Then User should see "User 'Talvanes' signed out successfully"
