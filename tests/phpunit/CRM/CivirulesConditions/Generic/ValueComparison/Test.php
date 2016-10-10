<?php

use Civi\Test\HeadlessInterface;
use Civi\Test\HookInterface;
use Civi\Test\TransactionalInterface;

/**
 * FIXME - Add test description.
 *
 * Tips:
 *  - With HookInterface, you may implement CiviCRM hooks directly in the test class.
 *    Simply create corresponding functions (e.g. "hook_civicrm_post(...)" or similar).
 *  - With TransactionalInterface, any data changes made by setUp() or test****() functions will
 *    rollback automatically -- as long as you don't manipulate schema or truncate tables.
 *    If this test needs to manipulate schema or truncate tables, then either:
 *       a. Do all that using setupHeadless() and Civi\Test.
 *       b. Disable TransactionalInterface, and handle all setup/teardown yourself.
 *
 * @group headless
 */
class CRM_CivirulesConditions_Generic_ValueComparison_Test extends \PHPUnit_Framework_TestCase implements HeadlessInterface, HookInterface, TransactionalInterface {

  public function setUpHeadless() {
    // Civi\Test has many helpers, like install(), uninstall(), sql(), and sqlFile().
    // See: https://github.com/civicrm/org.civicrm.testapalooza/blob/master/civi-test.md
    return \Civi\Test::headless()
      ->installMe(__DIR__)
      ->apply();
  }

  public function setUp() {
    parent::setUp();
  }

  public function tearDown() {
    parent::tearDown();
  }

  /**
   * Test the 'string contains' operator
   */
  public function testStringContains() {
    $valueComparisonTest = new ReflectionClass('CRM_CivirulesConditions_Generic_ValueComparison');
    $compareMethod = $valueComparisonTest->getMethod('compare');
    $compareMethod->setAccessible(true);

    $testObject = $this->getMockForAbstractClass('CRM_CivirulesConditions_Generic_ValueComparison',
        array(),
        '',
        FALSE,
        TRUE,
        TRUE,
        array()
        );

    // Test the string on the left contains the string on the right.
    $this->assertTrue($compareMethod->invoke($testObject, 'test', 'test', 'contains string'));
    $this->assertFalse($compareMethod->invoke($testObject, 'false', 'truth', 'contains string'));
    $this->assertTrue($compareMethod->invoke($testObject, 'yes please', 'yes', 'contains string'));
    $this->assertTrue($compareMethod->invoke($testObject, 'Yes please', 'yes', 'contains string')); // Test caps.
  }

}
