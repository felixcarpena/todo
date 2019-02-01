Feature:
  In order to prove the system can create and persist todo entries
  As a user
  I want to create a todo

  Scenario: It create a todo entry
    Given todo next Id generator will return: "6dc7ea5b-8315-4650-9551-9485b6e7aba6"
    When it create a todo with data:
      | description            |
      | some smart description |
    Then the todo: "6dc7ea5b-8315-4650-9551-9485b6e7aba6" and description: "some smart description" should exist