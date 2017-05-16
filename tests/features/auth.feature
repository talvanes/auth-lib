
  Feature: User Authentication

  Background:
    Given there are users:
     | username | password | name     | email           |
     | talba    | 123456   | Talvanes | talba@email.net |

    Scenario: User did not type either username or password
      Given User typed no username
      When User attempts to sign in
      Then User should see "You must type both username and password"

    Scenario: Username does not exist
      Given User typed username "foo"
        And User typed password "123456"
      When User attempts to sign in
      Then User should see "This username does not exist"

    Scenario: Username and password given do not match
      Given User typed username "talba"
        And User typed password "654321"
      When User attempts to sign in
      Then User should see "Username and password given do not match"

    @session
    Scenario: Username and password match
      Given User typed username "talba"
        And User typed password "123456"
      When User attempts to sign in
      Then User should see "User 'Talvanes' signed in successfully"

    Scenario: User signs out
      Given User "talba" has signed in with password "123456"
      When User attempts to sign out
      Then User should see "User 'Talvanes' signed out successfully"

    Scenario: User did not type either email or password
      Given User typed no email
      When User attempts to sign in
      Then User should see "You must type both email and password"

    Scenario: Email does not exist
      Given User typed email "foo@email.net"
      And User typed password "123456"
      When User attempts to sign in
      Then User should see "This email does not exist"

    Scenario: Email and password given do not match
      Given User typed email "talba@email.net"
      And User typed password "654321"
      When User attempts to sign in
      Then User should see "Email and password given do not match"

    @session
    Scenario: Email and password match
      Given User typed email "talba@email.net"
      And User typed password "123456"
      When User attempts to sign in
      Then User should see "User 'Talvanes' signed in successfully"

    Scenario: User signs out again
      Given Email "talba@email.net" has signed in with password "123456"
      When User attempts to sign out
      Then User should see "User 'Talvanes' signed out successfully"
