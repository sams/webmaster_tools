<?php
	$this->loadHelper('WebmasterTools.RobotControl');
	$this->RobotControl->deny('/');
	echo $this->RobotControl->generate();
?>