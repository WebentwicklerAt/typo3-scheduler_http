<?php
namespace WebentwicklerAt\SchedulerHttp\Task;

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
class GetUrlTask extends \TYPO3\CMS\Scheduler\Task\AbstractTask {
	/**
	 * URL
	 *
	 * @var string
	 */
	public $url;

	/**
	 * Function execute from the Scheduler
	 *
	 * @return bool TRUE on successful execution, FALSE on error
	 */
	public function execute() {
		$result = \TYPO3\CMS\Core\Utility\GeneralUtility::getUrl($this->url);

		if ($result !== FALSE) {
			return TRUE;
		}

		return FALSE;
	}

	/**
	 * This method returns the configured URL as additional information
	 *
	 * @return string
	 */
	public function getAdditionalInformation() {
		$message = sprintf(
			$GLOBALS['LANG']->sL('LLL:EXT:scheduler_http/Resources/Private/Language/locallang.xlf:label.getUrl.additionalInformationUrl'),
			$this->url
		);

		return $message;
	}
}
