<?php

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

	private $_revist = null;	
	private $_defaults = null;	
/**
 * Constructor
 *
 * @param string $message If no message is given 'Bad Request' will be the message
 * @param string $code Status code, defaults to 400
 */
	public function __construct($message = null, $code = 503) {
		$this->_defaults = Configure::read('WebmasterTools.Maintenance');
		if (empty($message)) {
			$message =  $this->_defaults['message'];
		}
		//$code = $this->_defaults['code'];
		$this->_revisit = $this->_defaults['revisit'];
		parent::__construct($message, $code);
	}
	
	public function getRevisit() {
		return $this->_revisit;
	}
}