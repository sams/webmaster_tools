<h2>Sitemap</h2>
<?php
$this->set('title_for_layout', 'Sitemap');

$this->loadHelper('WebmasterTools.Sitemap');

$this->set('title_for_layout', 'Sitemap');
	foreach ($mapData as $entity => $data) {
		$i = 0;
		$url = $data[':route']; unset($data[':route']);
		$type = $data[':type']; unset($data[':type']);
		//$url = array($page['Page']['slug']);
		for($i; $i < count($data); $i++) {
			if($type == 'static') {
				$title = Inflector::humanize($url[0]);
				$url = array_merge($url, $data);
			} else {
				// this should be the displayField
				$title = $data['title'];
				$type = $url[0]; unset($url[0]);
				$url = array_merge($url, $data[$type]);
			}
			debug($url);
			//debug($data[$i]);
		//debug($data);
		//$this->Sitemap->add($url , array(
		//	'section' => $entity,
		//	'title' => $title
		//));
		}
	}
echo $this->Sitemap->generate('html');