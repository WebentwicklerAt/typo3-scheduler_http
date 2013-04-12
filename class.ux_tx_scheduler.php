<?php

class ux_tx_scheduler extends tx_scheduler {
	
	public function __construct() {
			// Get configuration from the extension manager
		$this->extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['scheduler']);
		if (empty($this->extConf['maxLifetime'])) {
			$this->extConf['maxLifetime'] = 1440;
		}
		
		// there's no BE_USER
		$this->extConf['enableBELog'] = false;

			// Clean up the serialized execution arrays
		$this->cleanExecutionArrays();
	}
	
}
