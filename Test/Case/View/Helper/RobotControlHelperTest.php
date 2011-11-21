<?php
/* RobotControl Test cases generated on: 2011-11-21 10:11:31 : 1321872871*/
App::uses('Controller', 'Controller');
App::uses('Helper', 'View');
App::uses('AppHelper', 'View/Helper');
App::uses('ClassRegistry', 'Utility'); 
App::uses('RobotControlHelper', 'WebmasterTools.View/Helper');

if (!defined('FULL_BASE_URL')) {
	define('FULL_BASE_URL', 'http://localhost');
}

/**
 * TestController class
 *
 * @package       Cake.Test.Case.View.Helper
 */
class TestController extends Controller {

/**
 * name property
 *
 * @var string 'TheTest'
 */
	public $name = 'TheTest';

/**
 * uses property
 *
 * @var mixed null
 */
	public $uses = null;
}

/**
 * Robot Control Helper Class Test
 *
 * @package    webmaster_tools
 * @subpackage webmaster_tools.tests.cases.views.helpers
 */
class RobotControlHelperTest extends CakeTestCase {

	public $Helper;

	protected $_online;

	public function setUp() {
		parent::setUp();
		$this->View = $this->getMock('View', null, array(new TestController()));
		$this->_online = (boolean) @fsockopen('cakephp.org', 80);
		$this->RobotControl = new RobotControlHelper($this->View);
	}

	public function endTest() {
		unset($this->RobotControl);
		ClassRegistry::flush();
	}

	public function testAllow() {

	}

	public function testDeny() {

	}

	public function testSitemap() {

	}

	public function testCrawlDelay() {

	}

	public function testVisitTime() {

	}

	public function testRequestRate() {

	}

	public function testComment() {

	}

	public function testGenerate() {

	}

}
?>