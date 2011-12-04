<?php
/**
 * WebmasterTools Controller File
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
 * @subpackage webmaster_tools.controllers
 * @copyright  2010 David Persson <davidpersson@gmx.de>
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License
 */

/**
 * WebmasterTools Controller Class
 *
 * @package    webmaster_tools
 * @subpackage webmaster_tools.controllers
 */
App::uses('WebmasterToolsAppController', 'WebmasterTools.Controller');
class WebmasterToolsController extends WebmasterToolsAppController {

	public $uses = array();
	private $_ext = false;

	public function beforeFilter() {
		parent::beforeFilter();
		$this->_ext = (!empty($this->request->params['ext'])) ? $this->request->params['ext'] : false;

		if (isset($this->Auth)) {
			$this->Auth->allow('sitemap', 'robot_control');
		} elseif (isset($this->Gate)) {
			$this->Gate->Auth->allow('sitemap', 'robot_control');
		}

		if (!empty($this->request->params['ext'])) {
			$this->response->type($this->request->params['ext']);
		}
	}

	public function beforeRender() {
		parent::beforeRender();
	}

	public function sitemap(){
		$mapData = $mapModels = $tmp = $mapText = array();
		$mapModels = Configure::read('WebmasterTools.mapModels');
		
		//debug($mapModels);
		
		$controller = false;
		
		foreach($mapModels as $model => $params) {
			$controller = Inflector::pluralize($model);
			$url = array();
			$action = 'display';
			$type = 'static';
    
			if($controller == $model) {
				$model = Inflector::singularize($controller);
				$tmp[$controller][':type'] = 'static';
				$tmp[$controller][':route'] = $params[0];
				$items = array_keys($params[0]);
			} else {
				$method = $params[1][':method'];
				$type = $params[1][':type'];
				$args = $params[1][':args'];
				// a model using find
				$this->loadModel($model);
				$$model = new $model;
				$tmp[$controller] = $$model->$method($type, $args);
				$tmp[$controller][':type'] = 'dynamic';
				$tmp[$controller][':route'] = $params[0];		
			}
				
			$title = $changes = $priority = $changes = $modified = $section = null;
			$sitemapDefaults = array(
				'modified' => null,
				'changes' => null, // always, hourly, daily, weekly, monthly, yearly, never.
				'priority' => null, // 0.0 - 1.0 (most important), 0.5 is considered the default.
				'title' => null, // For XML used as comment, otherwise for HTML.
				'section' => null, // Used for HTML only.
				'images' => array()
			);
			
			//diebug($tmp[$controller]);
			
			if(!$this->_ext) {
				$mapText[$controller]['section'] = (!empty($mapModels[$controller][':section'])) ? $mapModels[$controller][':section'] : null;
				$mapText[$controller]['description'] = (!empty($mapModels[$controller][':description'])) ? $mapModels[$controller][':description'] : false;
			}
			
			// logic moved from sitemap view
			$i = $j = 0;
			for($i; $i < count($items); $i++) {	
				for($j; $j < count($tmp[$controller][':route']); $j++) {
					if($type == 'static') {
						$url = $tmp[$controller][':route'][$items[$j]]['url'];
						unset($tmp[$controller][':route'][$items[$j]]['url']);
						$data = $tmp[$controller][':route'][$items[$j]];
						//if()
						//$url = array('controller' => $controller, 'action' => $action, 'plugin' => null, $url);
					} else {
						// this should be the displayField
						$title = $tmp[$controller][$items[$j]]['title'];
						$type = $tmp[$controller][$items[$j]][':route']; unset($tmp[$controller][$items[$j]]);
						$url = array_merge($url, $tmp[$controller][$type]);
					}
		
					$data['section'] = $controller; 	
					
					$mapData[$controller][$j] = array(
								'url' => $url,
								'data' => array_merge($sitemapDefaults, $data)
							);
				}
			}
		}
		
		$this->set(compact('mapData', 'mapText'));
		    
		if($this->_ext == 'xml') {
		Configure::write('debug', 0);
		    $template = APP . 'View' . DS . 'WebmasterTools' . DS . 'xml' . DS . 'sitemap' . '.ctp';
		    $template = (file_exists($template)) ? $template : 'xml/sitemap';
		    return $this->render($template, 'xml/default');
		}
		    
		    
		$theme = '';
		if($this->theme) $theme = 'Themed' . DS . $this->theme . DS;  
		$template = APP . 'View' . DS . $theme . 'WebmasterTools' . DS . 'sitemap' . '.ctp';
		$template = (file_exists($template)) ? $template : 'sitemap';
		$this->render($template);
	}
	
	public function robot_control() {
		if($this->_ext == 'txt') {
		    $template = APP . 'View' . DS . 'WebmasterTools' . DS . 'txt' . DS . 'robot_control' . '.ctp';
		    $template = (file_exists($template)) ? $template : 'txt/robot_control';
		    $this->render($template, 'ajax');
		} else {
		    throw new NotFoundException;
		}
	}

}
