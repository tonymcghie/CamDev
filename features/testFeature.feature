@behat_test
Feature: test that behat works
  
  Scenario: test scenario
    When I go to the homepage
    Then I should be on page "http://192.168.20.20/CamDev/users/login"
    And I should see "Find"
    And I follow the link "Find"
    Then I should be on page "http://192.168.20.20/CamDev/SampleSets/search"