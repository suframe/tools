<?php
namespace suframe\tools\umeng\notification\android;

use suframe\tools\umeng\notification\AndroidNotification;

class AndroidBroadcast extends AndroidNotification {
	function  __construct() {
		parent::__construct();
		$this->data["type"] = "broadcast";
	}
}