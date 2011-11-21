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
		$this->Maintenance->actiavte('close for now');
	}

/**
 * 
 */
	public function closed_for_maintenance() {
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

		$this->Maintenance = new MaintenanceComponent($this->Controller);
		$this->Controller->_Config = $config;
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
		$this->Controller->beforeFilter();
		$this->Controller->closed_for_maintenance();
		//$this->Maintenance->actiavte();

	}

}
