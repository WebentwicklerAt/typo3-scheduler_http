<?php
namespace WebentwicklerAt\SchedulerHttp\Task;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Scheduler\AdditionalFieldProviderInterface;
use TYPO3\CMS\Scheduler\Controller\SchedulerModuleController;
use TYPO3\CMS\Scheduler\Task\AbstractTask;

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
class GetUrlTaskAdditionalFieldProvider implements AdditionalFieldProviderInterface
{
    /**
     * Default field values
     *
     * @var array
     */
    protected $defaults = [
        'url' => 'https://webentwickler.at/',
    ];

    /**
     * Add a text field for URL configuration
     *
     * @param array $taskInfo Reference to the array containing the info used in add/edit task form
     * @param AbstractTask $task The task object being edited. Null when adding a task!
     * @param SchedulerModuleController $schedulerModule Reference to the scheduler backend module
     * @return array Array containing all the information pertaining to the additional fields
     */
    public function getAdditionalFields(
        array &$taskInfo,
        $task,
        SchedulerModuleController $schedulerModule
    ) {
        $fieldId = 'url';

        if (!isset($taskInfo[$fieldId])) {
            $taskInfo[$fieldId] = $this->defaults[$fieldId];
            if ($schedulerModule->getCurrentAction()->equals('edit')) {
                $taskInfo[$fieldId] = $task->$fieldId;
            }
        }

        $additionalFields[$fieldId] = [
            'code' => '<input type="text" name="tx_scheduler[' . $fieldId . ']" id="' . $fieldId . '" value="' . htmlspecialchars($taskInfo[$fieldId]) . '" size="60" />',
            'label' => 'LLL:EXT:scheduler_http/Resources/Private/Language/locallang.xlf:label.getUrlTaskAdditionalFieldProvider.' . $fieldId,
        ];

        return $additionalFields;
    }

    /**
     * @param array $submittedData Reference to the array containing the data submitted by the add/edit task form
     * @param SchedulerModuleController $schedulerModule Reference to the scheduler backend module
     * @return bool TRUE if validation was ok (or selected class is not relevant), FALSE otherwise
     */
    public function validateAdditionalFields(
        array &$submittedData,
        SchedulerModuleController $schedulerModule
    ) {
        $validData = true;

        if (!GeneralUtility::isValidUrl($submittedData['url'])) {
            $validData = false;
        }

        return $validData;
    }

    /**
     * @param array $submittedData An array containing the data submitted by the add/edit task form
     * @param AbstractTask $task Reference to the scheduler backend module
     * @return void
     */
    public function saveAdditionalFields(array $submittedData, AbstractTask $task)
    {
        $task->url = $submittedData['url'];
    }
}
