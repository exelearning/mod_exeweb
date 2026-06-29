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
  # Embed mode (display=1) renders the package in an iframe; its server-rendered src must
  # carry the parameter when the setting is on, for any viewer.
  # The "should not contain amp;exe-teacher" guard catches the double-escaping regression
  # (PR #65): the renderer must pass the raw URL to the iframe template so mustache escapes
  # the ampersand once. If it passed an already-escaped URL, &amp; would become &amp;amp;
  # and the browser would parse the parameter as "amp;exe-teacher", silently dropping it —
  # while "should contain exe-teacher=1" alone would still pass, since that substring survives.
  Scenario: A teacher sees the exe-teacher parameter when the setting is on
    Given the following "activities" exist:
      | activity | course | name           | display | teachermodevisible |
      | exeweb   | C1     | Teacher reveal | 1       | 1                  |
    And I am on the "Teacher reveal" "exeweb activity" page logged in as teacher1
    Then the "src" attribute of "iframe#exewebobject" "css_element" should contain "exe-teacher=1"
    And the "src" attribute of "iframe#exewebobject" "css_element" should not contain "amp;exe-teacher"

  Scenario: A teacher does not see the exe-teacher parameter when the reveal is off
    Given the following "activities" exist:
      | activity | course | name             | display | teachermodevisible |
      | exeweb   | C1     | Teacher noreveal | 1       | 0                  |
    And I am on the "Teacher noreveal" "exeweb activity" page logged in as teacher1
    Then the "src" attribute of "iframe#exewebobject" "css_element" should not contain "exe-teacher"

  Scenario: A student also sees the exe-teacher parameter when the setting is on
    Given the following "activities" exist:
      | activity | course | name               | display | teachermodevisible |
      | exeweb   | C1     | Teacher student vw | 1       | 1                  |
    And I am on the "Teacher student vw" "exeweb activity" page logged in as student1
    Then the "src" attribute of "iframe#exewebobject" "css_element" should contain "exe-teacher=1"
    And the "src" attribute of "iframe#exewebobject" "css_element" should not contain "amp;exe-teacher"

  # Popup mode (display=6) does not embed an iframe: it renders a server-side "click to open"
  # link on the workaround page, whose href and window.open() URL must also carry the
  # parameter — otherwise the package opens without the teacher-layer selector in the
  # non-embed modes, the regression reported on PR #65.
  Scenario: The popup link and window.open URL carry the exe-teacher parameter when the setting is on
    Given the following "activities" exist:
      | activity | course | name         | display | teachermodevisible |
      | exeweb   | C1     | Popup reveal | 6       | 1                  |
    And I am on the "Popup reveal" "exeweb activity" page logged in as teacher1
    Then the "href" attribute of ".exewebworkaround a" "css_element" should contain "exe-teacher=1"
    And the "onclick" attribute of ".exewebworkaround a" "css_element" should contain "exe-teacher=1"

  Scenario: The popup link omits the exe-teacher parameter when the reveal is off
    Given the following "activities" exist:
      | activity | course | name           | display | teachermodevisible |
      | exeweb   | C1     | Popup noreveal | 6       | 0                  |
    And I am on the "Popup noreveal" "exeweb activity" page logged in as teacher1
    Then the "href" attribute of ".exewebworkaround a" "css_element" should not contain "exe-teacher"
