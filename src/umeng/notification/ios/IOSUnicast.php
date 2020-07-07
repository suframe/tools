<?php
namespace suframe\tools\umeng\notification\ios;

use suframe\tools\umeng\notification\IOSNotification;

class IOSUnicast extends IOSNotification {
	function __construct() {
		parent::__construct();
		$this->data["type"] = "unicast";
		$this->data["device_tokens"] = NULL;
	}

}