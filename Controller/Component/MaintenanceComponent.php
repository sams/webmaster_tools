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

/**
 * Parent class for all of the HTTP related exceptions in CakePHP.
 * All HTTP status/error related exceptions should extend this class so
 * catch blocks can be specifically typed.
 *
 * @package       Cake.Error
 */
if (!class_exists('HttpException')) {
	class HttpException extends RuntimeException { }
}

/**
 * Represents an HTTP 503 error.
 *
 * @package       WebmasterTool.Lib.Error
 */
class MaintenanceException extends HttpException {
/**
 * Constructor
 *
 * @param string $message If no message is given 'Bad Request' will be the message
 * @param string $code Status code, defaults to 400
 */
	public function __construct($message = null, $code = 503) {
		if (empty($message)) {
			$message = 'Down for Maintenance';
		}
		parent::__construct($message, $code);
	}
}
/**
 * Maintenance Component Class
 *
 * @package    webmaster_tools
 * @subpackage webmaster_tools.controllers.components
 */
class MaintenanceComponent extends Component {
	/**
	 * Activates maintenance mode.
	 *
	 * Disables debug mode (if activated for i.e. admin) and sets
	 * an appropriate header.
	 *
	 * Example usage:
	 * {{{
	 * if (!$isAdmin && Configure::read('Server.maintenance')) {
	 *	$this->Maintenance->activate();
	 * }
	 * }}}
	 *
	 * @return void
	 * @link http://mark-story.com/posts/view/quick-and-dirty-down-for-maintenance-page-with-cakephp
	 */
	public function activate($message = null) {
		Configure::write('debug', 2);

		throw new MaintenanceException('Down for some Mainentance');
	}
}

?>