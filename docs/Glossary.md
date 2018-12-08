# Glossary

## Component
The component is a PHP mapping similar to the testsuite and testcase elements in the test log file.

### Example
XML:
```xml
<testsuite name="CommandFactoryTest" file="tests/phpunit/includes/shell/CommandFactoryTest.php" assertions="7" tests="3" errors="0" failures="0" skipped="0" time="0.057585">

</testsuite>
```

PHP mapping:
```php
class RazeSoldier\JUnitLogParser\Component\TestSuite#20 (10) {
  private $testsCount =>
  int(3)
  private $errorsCount =>
  int(0)
  private $failuresCount =>
  int(0)
  private $skippedCount =>
  int(0)
  protected $name =>
  string(18) "CommandFactoryTest"
  protected $assertionsCount =>
  int(7)
  protected $time =>
  double(0.057585)
  protected $file =>
  string(64) "w/tests/phpunit/includes/shell/CommandFactoryTest.php"
  protected $parent =>
  NULL
  protected $children =>
  array(0) {
  }
}
```