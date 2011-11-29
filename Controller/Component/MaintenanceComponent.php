<?php
/**
 * Maintenance Component File
 *
 * Copyright (c) 2010 David Persson
 *
 * Distributed under the terms of the MIT License.
 * Redistributions of files must retain the above copyright notice.
 *
 * PHP version 5
 * CakePHP version 1.3
 *
 * @package    webmaster_tools
 * @subpackage webmaster_tools.controllers.components
 * @copyright  2010 David Persson <davidpersson@gmx.de>
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License
 */
App::uses('Component', 'Controller');
/**
 * Maintenance Component Class
 *
 * @package    webmaster_tools
 * @subpackage webmaster_tools.controllers.components
 */
class MaintenanceComponent extends Component {

	private $__Controller;

	public function initialize(Controller $Controller) {
		$this->__Controller = $Controller;
	}

	/**
	 * Activates maintenance mode.
	 *
	 * Disables debug mode (if activated for i.e. admin) and sets
	 * an appropriate header.
	 *
	 * Example usage:
	 * {{{
	 * if (!$isAdmin && Configure::read('WebmasterTools.Maintenance.active')) {
	 *	$this->Maintenance->activate();
	 * }
	 * }}}
	 *
	 * @return void
	 */
	public function activate($message = null) {
		Configure::write('debug', 0);
		throw new MaintenanceException($message);
	}
}

?>