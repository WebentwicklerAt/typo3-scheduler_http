<?php
namespace WebentwicklerAt\SchedulerHttp\Xclass;

class Scheduler extends \TYPO3\CMS\Scheduler\Scheduler {
	/**
	 * Constructor, makes sure all derived client classes are included
	 *
	 * @return \TYPO3\CMS\Scheduler\Scheduler
	 */
	public function __construct() {
		// Get configuration from the extension manager
		$this->extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['scheduler']);
		if (empty($this->extConf['maxLifetime'])) {
			$this->extConf['maxLifetime'] = 1440;
		}
		if (empty($this->extConf['useAtdaemon'])) {
			$this->extConf['useAtdaemon'] = 0;
		}

		// there's no BE_USER
		$this->extConf['enableBELog'] = FALSE;

		// Clean up the serialized execution arrays
		$this->cleanExecutionArrays();
	}
}
