<h2>Sitemap</h2>
<?php

$this->loadHelper('WebmasterTools.Sitemap');

$this->set('title_for_layout', 'Sitemap');
	foreach ($mapData as $section => $entity) {
		$this->Sitemap->addSection($section, $mapText[$section]);
		for($i = 0; $i < count($entity); $i++) {
			$this->Sitemap->add(Router::url($entity[$i]['url']) , $entity[$i]['data']);
		}
	}
echo $this->Sitemap->generate('html');