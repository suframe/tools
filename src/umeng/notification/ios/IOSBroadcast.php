<?php
namespace suframe\tools\umeng\notification\ios;

use suframe\tools\umeng\notification\IOSNotification;

class IOSBroadcast extends IOSNotification {
	function  __construct() {
		parent::__construct();
		$this->data["type"] = "broadcast";
	}
}