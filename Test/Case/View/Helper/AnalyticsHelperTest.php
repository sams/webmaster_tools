<?php
/* Analytics Test cases generated on: 2011-11-21 10:11:40 : 1321872880*/
App::uses('Controller', 'Controller');
App::uses('Helper', 'View');
App::uses('AppHelper', 'View/Helper');
App::uses('ClassRegistry', 'Utility'); 
App::uses('AnalyticsHelper', 'WebmasterTools.View/Helper');

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
class AnalyticsHelperTest extends CakeTestCase {

	public $Helper;

	protected $_online;

	public function setUp() {
		parent::setUp();
		$this->View = $this->getMock('View', null, array(new TestController()));
		$this->_online = (boolean) @fsockopen('cakephp.org', 80);
		$this->Analytics = new AnalyticsHelper($this->View);
	}

	public function endTest() {
		unset($this->Analytics);
		ClassRegistry::flush();
	}

	public function testConfig() {

	}

	public function testAnonymizeIp() {

	}

	public function testVariable() {

	}

	public function testTrackPageview() {

	}

	public function testGenerate() {

	}

}
?>