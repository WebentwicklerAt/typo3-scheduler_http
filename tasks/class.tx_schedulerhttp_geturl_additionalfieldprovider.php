<?php

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
