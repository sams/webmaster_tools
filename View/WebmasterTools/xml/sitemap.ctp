<?php
	$this->loadHelper('WebmasterTools.Sitemap');
	foreach ($mapData as $entity => $data) {
		$i = 0;
		$url = array();
		$controller = Inflector::underscore($entity);
		$type = $data[':type'];
		for($i; $i < count($data[':route']); $i++) {	
			if($type == 'static') {
				$action = 'display';
				$changes = 'always';
				$priority = 0.6;
				$title = Inflector::humanize($data[':route'][$i]);
				$url = array('controller' => $controller, 'action' => $action, 'plugin' => null, $data[':route'][$i]);
			} else {
				// this should be the displayField
				$action = 'view';
				$changes = 'always';
				$priority = 1.0;
				$title = $data[':route']['title'];
				$type = $data[':route'][$i]; unset($data[':route'][$i]);
				$url = array_merge($url, $data[':route'][$type]);
			}
			$this->Sitemap->add($url , array(
				'section' => $entity,
				'title' => $title,
				'changes' => $changes,
				'priority' => $priority
			));
		}
	}
	echo $this->Sitemap->generate();
?>