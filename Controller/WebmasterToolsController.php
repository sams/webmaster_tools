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

	public function beforeFilter() {
		parent::beforeFilter();

		if (isset($this->Auth)) {
			$this->Auth->allow('sitemap', 'robot_control');
		} elseif (isset($this->Gate)) {
			$this->Gate->Auth->allow('sitemap', 'robot_control');
		}

		if (!empty($this->request->params['ext'])) {
				$this->response->type($this->request->params['ext']);
		}
	}

    public function sitemap(){
		
		//debug($this->response);
		//diebug($this->request->params['ext']);
		$mapData = $mapModels = array();
		$mapModels = Configure::read('WebmasterTools.mapModels');
		
		$controller = false;
		
		foreach($mapModels as $model => $params) {
			$controller = Inflector::pluralize($model);
			//debug($model);
			//debug($controller);
			//debug($params);

			if($controller == $model) {
				$model = Inflector::singularize($model);
				// static route controller eg Pages
				foreach($params[1] as $item => $data) {
					$mapData[$controller][$item][$model] = array($data);
				}	
				$mapData[$controller][':type'] = 'static';
				$mapData[$controller][':route'] = array_merge(array('controller' => $controller), $params[0]);
			} else {
				$method = $params[1][':method'];
				$type = $params[1][':type'];
				$args = $params[1][':args'];
				// a model using find
				$this->loadModel($model);
				$$model = new $model;
				$mapData[$controller] = $$model->$method($type, $args);
				$mapData[$controller][':type'] = 'dynamic';
				$mapData[$controller][':route'] = array_merge(array('controller' => $controller), $params[0]);		
			}
			
		}
		
		#diebug($mapData);
		
		$this->set(compact('mapData'));
	}

    public function robot_control() {
		$this->render('txt/robot_control');
    }

}

?>