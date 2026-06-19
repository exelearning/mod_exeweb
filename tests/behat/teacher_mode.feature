@mod @mod_exeweb
Feature: Show the eXeLearning teacher-layer selector via the exe-teacher URL parameter
  In order to let viewers show or hide the teacher-only layer of an embedded eXeLearning resource
  As a teacher configuring the activity
  I need the embedded resource to expose its teacher-layer selector when the per-activity setting is on

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email                |
      | teacher1 | Teacher   | One      | teacher1@example.com |
      | student1 | Student   | One      | student1@example.com |
    And the following "courses" exist:
      | fullname | shortname | category |
      | Course 1 | C1        | 0        |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | teacher1 | C1     | editingteacher |
      | student1 | C1     | student        |

  # The iframe src is server-rendered, so these scenarios assert on it directly
  # without @javascript. eXeLearning hides teacher-only content by default and exposes a
  # selector to show it via the package's own ?exe-teacher=1 URL parameter (upstream
  # exelearning#1772); the plugin appends it whenever the per-activity "Show teacher
  # layer selector" setting is on — for any viewer.
  Scenario: A teacher sees the exe-teacher parameter when the setting is on
    Given the following "activities" exist:
      | activity | course | name           | display | teachermodevisible |
      | exeweb   | C1     | Teacher reveal | 5       | 1                  |
    And I am on the "Teacher reveal" "exeweb activity" page logged in as teacher1
    Then the "src" attribute of "iframe#exewebobject" "css_element" should contain "exe-teacher=1"

  Scenario: A teacher does not see the exe-teacher parameter when the reveal is off
    Given the following "activities" exist:
      | activity | course | name             | display | teachermodevisible |
      | exeweb   | C1     | Teacher noreveal | 5       | 0                  |
    And I am on the "Teacher noreveal" "exeweb activity" page logged in as teacher1
    Then the "src" attribute of "iframe#exewebobject" "css_element" should not contain "exe-teacher"

  Scenario: A student also sees the exe-teacher parameter when the setting is on
    Given the following "activities" exist:
      | activity | course | name               | display | teachermodevisible |
      | exeweb   | C1     | Teacher student vw | 5       | 1                  |
    And I am on the "Teacher student vw" "exeweb activity" page logged in as student1
    Then the "src" attribute of "iframe#exewebobject" "css_element" should contain "exe-teacher=1"
