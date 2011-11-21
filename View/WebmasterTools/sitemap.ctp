<h2>Sitemap</h2>
<?php
$this->set('title_for_layout', 'Sitemap');

$this->loadHelper('WebmasterTools.Sitemap');

$this->set('title_for_layout', 'Sitemap');
	foreach ($mapData as $entity => $data) {
		//debug($data);
		$i = 0;
		$url = array();
		$controller = Inflector::underscore($entity);
		$action = 'display';
		$type = $data[':type'];
		for($i; $i < count($data[':route']); $i++) {	
			//debug($data[':route'][$i]);	
			if($type == 'static') {
				$title = Inflector::humanize($data[':route'][$i]);
				$url = array('controller' => $controller, 'action' => $action, 'plugin' => null, $data[':route'][$i]);
			} else {
				// this should be the displayField
				$title = $data['title'];
				$type = $url[$i]; unset($url[$i]);
				$url = array_merge($url, $data[$type]);
			}
			debug($url);
		$this->Sitemap->add($url , array(
			'section' => $entity,
			'title' => $title
		));
			debug($action);
			debug($action);
			debug($type);
			debug($controller);
			echo "<hr><br><br><br><br><br><br>";
		}
		debug($entity);
		//debug($data);
	}
echo $this->Sitemap->generate('html');