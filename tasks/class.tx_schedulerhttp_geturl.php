<?php

class tx_schedulerhttp_geturl extends tx_scheduler_Task {
	
	public $url;
	
	/**
	 * scheduler execute function
	 */
	public function execute() {
		$result = t3lib_div::getUrl($this->url);
		
		if ($result !== false) {
			return true;
		}
		
		return false;
	}
	
}
