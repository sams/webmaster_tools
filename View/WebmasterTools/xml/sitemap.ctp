<?php
	$this->loadHelper('WebmasterTools.Sitemap');
	$this->Sitemap->add('/bla', array(
		'changes' => 'always'
	));
	echo $this->Sitemap->generate();
?>