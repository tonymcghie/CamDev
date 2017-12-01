@behat_test
Feature: test that behat works
  
  Scenario: test scenario
    When I go to the homepage
    Then I should be on page "http://localhost/CamDev"
    And I should see "New"
    And I follow the link "New"

  Scenario: test scenario