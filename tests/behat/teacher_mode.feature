@mod @mod_exeweb
Feature: Reveal eXeLearning teacher content via the exe-teacher URL parameter
  In order to keep teacher-only content hidden from students
  As a teacher
  I need the embedded resource to request the teacher view only for teachers who opted in

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
  # without @javascript. eXeLearning hides teacher-only content by default and reveals
  # it via the package's own ?exe-teacher=1 URL parameter (upstream exelearning#1772);
  # the plugin appends it only for users who can manage the activity AND when the
  # per-activity "Reveal eXeLearning teacher content to teachers" setting is on.
  Scenario: A teacher sees the exe-teacher parameter when teacher content is revealed
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

  Scenario: A student never sees the exe-teacher parameter even when the reveal is on
    Given the following "activities" exist:
      | activity | course | name               | display | teachermodevisible |
      | exeweb   | C1     | Teacher student vw | 5       | 1                  |
    And I am on the "Teacher student vw" "exeweb activity" page logged in as student1
    Then the "src" attribute of "iframe#exewebobject" "css_element" should not contain "exe-teacher"
