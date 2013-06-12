<?php
/***************************************************************
*  Copyright notice
*
*  (c) Gernot Leitgab <leitgab@gmail.com>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

class tx_schedulerhttp_geturl_additionalfieldprovider implements tx_scheduler_AdditionalFieldProvider {
	
	protected $extKey = 'tx_schedulerhttp_geturl';
	protected $defaults = array(
		'url' => 'http://www.example.org/',
	);
	
	public function getAdditionalFields(array &$taskInfo, $task, tx_scheduler_Module $parentObject) {
		// wsdl_lists
		$fieldId = 'url';
		
		if (!isset($taskInfo[$fieldId])) {
			$taskInfo[$fieldId] = $this->defaults[$fieldId];
			if ($parentObject->CMD === 'edit') {
				$taskInfo[$fieldId] = $task->$fieldId;
			}
		}
		
		$additionalFields[$fieldId] = array(
			'code'  => '<input type="text" name="tx_scheduler[' . $fieldId . ']" id="' . $fieldId . '" value="' . htmlspecialchars($taskInfo[$fieldId]) . '" />',
			'label' => 'LLL:EXT:scheduler_http/locallang.xml:label.' . $this->extKey . '.' . $fieldId,
		);
		
		return $additionalFields;
	}
	
	public function validateAdditionalFields(array &$submittedData, tx_scheduler_Module $parentObject) {
		$validData = TRUE;
		
		if (!t3lib_div::isValidUrl($submittedData['url'])) {
			$validData = FALSE;
		}
		
		return $validData;
	}
	
	public function saveAdditionalFields(array $submittedData, tx_scheduler_Task $task) {
		$task->url = $submittedData['url'];
	}
	
}
