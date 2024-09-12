<?php
namespace WebentwicklerAt\SchedulerHttp\Task;
use TYPO3\CMS\Scheduler\Task\Enumeration\Action;
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
 * Additional BE fields for getUrl task.
 *
 * @author Gernot Leitgab <https://webentwickler.at>
 */
class GetUrlTaskAdditionalFieldProvider implements \TYPO3\CMS\Scheduler\AdditionalFieldProviderInterface {
	/**
	 * Default field values
	 *
	 * @var array
	 */
	protected $defaults = array(
		'url' => 'https://webentwickler.at/',
	);

	/**
	 * Add a text field for URL configuration
	 *
	 * @param array $taskInfo Reference to the array containing the info used in add/edit task form
	 * @param \TYPO3\CMS\Scheduler\Task\AbstractTask $task The task object being edited. Null when adding a task!
	 * @param \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $schedulerModule Reference to the scheduler backend module
	 * @return array Array containing all the information pertaining to the additional fields
	 */
	public function getAdditionalFields(array &$taskInfo, $task, \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $schedulerModule) {
		$fieldId = 'url';
		
		$additionalFields = [];
		$schedulerModule = $schedulerModule->getCurrentAction();

		if (!isset($taskInfo[$fieldId])) {
			$taskInfo[$fieldId] = $this->defaults[$fieldId];
			if ($schedulerModule->equals(Action::EDIT)) {
				$taskInfo[$fieldId] = $task->getUrl();
			}
		}

		$additionalFields[$fieldId] = array(
			'code'  => '<input type="text" name="tx_scheduler[' . $fieldId . ']" id="' . $fieldId . '" value="' . htmlspecialchars($taskInfo[$fieldId]) . '" size="60" />',
			'label' => 'LLL:EXT:scheduler_http/Resources/Private/Language/locallang.xlf:label.getUrlTaskAdditionalFieldProvider.' . $fieldId,
		);

		return $additionalFields;
	}

	/**
	 * @param array $submittedData Reference to the array containing the data submitted by the add/edit task form
	 * @param \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $schedulerModule Reference to the scheduler backend module
	 * @return bool TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
	 */
	public function validateAdditionalFields(array &$submittedData, \TYPO3\CMS\Scheduler\Controller\SchedulerModuleController $schedulerModule) {
		$validData = TRUE;

		if (!\TYPO3\CMS\Core\Utility\GeneralUtility::isValidUrl($submittedData['url'])) {
			$validData = FALSE;
		}

		return $validData;
	}

	/**
	 * @param array $submittedData An array containing the data submitted by the add/edit task form
	 * @param \TYPO3\CMS\Scheduler\Task\AbstractTask $task Reference to the scheduler backend module
	 * @return void
	 */
	public function saveAdditionalFields(array $submittedData, \TYPO3\CMS\Scheduler\Task\AbstractTask $task) {
		$task->url = $submittedData['url'];
	}
}
