<?php
/* Maintenance Test cases generated on: 2011-11-21 12:05:52 : 1321877152*/
App::uses('CakeResponse', 'Network');
App::uses('CakeRequest', 'Network');
App::uses('Controller', 'Controller');
App::uses('AppController', 'Controller');
App::uses('MaintenanceComponent', 'WebmasterTools.Controller/Component');

class Article extends CakeTestModel {
/**
 * 
 */
	public $name = 'Article';
}

class ArticlesTestController extends Controller {

/**
 * @var string
 * @access public
 */
	public $name = 'ArticlesTest';

/**
 * @var array
 * @access public
 */
	public $uses = array('Article');

/**
 * @var array
 * @access public
 */
	public $components = array('WebmasterTools.Maintenance');

/**
 * 
 */
	public function beforeFilter() {
		$this->Maintenance->activate();
	}

/**
 * 
 */
	public function closed_for_maintenance() {
	}

}

class Articles2TestController extends Controller {

/**
 * @var string
 * @access public
 */
	public $name = 'ArticlesTest';

/**
 * @var array
 * @access public
 */
	public $uses = array('Article');

/**
 * @var array
 * @access public
 */
	public $components = array('WebmasterTools.Maintenance');

/**
 * 
 */
	public function index() {
		$this->Maintenance->activate('closed for now');
	}

}

/**
 * MaintenanceComponent Test Case
 *
 */
class MaintenanceComponentTestCase extends CakeTestCase {
/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Controller = new ArticlesTestController();
		$this->Controller->constructClasses();
		$this->Controller->action = 'closed_for_maintenance';
		$this->Controller->params = array(
			'named' => array(),
			'pass' => array(),
			'url' => array());
		$this->Controller->modelClass = 'Article';

		$this->Maintenance = new MaintenanceComponent($this->Controller->Components);
		//$this->_config = $config;
		$this->_debug = Configure::read('debug');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		Configure::write('debug', $this->_debug);
		unset($this->Maintenance);

		parent::tearDown();
	}

/**
 * testActivate method
 *
 * @return void
 */
	public function testActivate() {
			Configure::write('WebmasterTools.Maintenance', array(
				'active' => false,
				'message' => 'Not much to see here',
				'title' => 'We are in Maintenance Mode',
				'revisit' => MONTH,
				'layout' => 'ajax'
			));
		try {
			$this->Controller->beforeFilter();
			$this->Controller->closed_for_maintenance();
		} catch (Exception $e) {
			Configure::write('debug', 2);
			$this->assertInstanceOf('MaintenanceException', $e);
			Configure::write('debug', 0);
		}

	}
	
	public function testSuspend() {
		$this->Controller = new Articles2TestController();
		$this->Controller->constructClasses();
		$this->Controller->action = 'index';
		$this->Controller->params = array(
			'named' => array(),
			'pass' => array(),
			'url' => array());
		$this->Controller->modelClass = 'Article';

		$this->Maintenance = new MaintenanceComponent($this->Controller->Components);
		try {
			$this->Controller->beforeFilter();
			$this->Controller->index();
		} catch (Exception $e) {
			Configure::write('debug', 2);
			$this->assertInstanceOf('MaintenanceException', $e);
			Configure::write('debug', 0);
		}
	}

}
