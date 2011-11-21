<?php


	$this->loadHelper('WebmasterTools.Sitemap');
	foreach ($mapData as $section => $entity) {
		for($i = 0; $i < count($entity); $i++) {
			$this->Sitemap->add(Router::url($entity[$i]['url']) , $entity[$i]['data']);
		}
	}
	echo $this->Sitemap->generate();
?>