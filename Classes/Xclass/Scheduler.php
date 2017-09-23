<?php
namespace WebentwicklerAt\SchedulerHttp\Xclass;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Scheduler task doing GET-Requests.
 *
 * @author Gernot Leitgab <https://webentwickler.at>
 */
class Scheduler extends \TYPO3\CMS\Scheduler\Scheduler {
	/**
	 * Constructor, makes sure all derived client classes are included
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
