<?php
	$this->layout = 'ajax';
	$this->loadHelper('WebmasterTools.RobotControl');
	$this->RobotControl->deny('/');
	echo $this->RobotControl->generate();
?>