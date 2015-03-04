<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

$boot = function($_EXTKEY) {
	// Adding alternative output engine to eID mechanism
	$GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include'][$_EXTKEY] = 'EXT:' . $_EXTKEY . '/Classes/Eid/SchedulerHttpEid.php';

	// Adding scheduler task
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['WebentwicklerAt\\SchedulerHttp\\Task\\GetUrlTask'] = array(
		'extension'        => $_EXTKEY,
		'title'            => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xlf:getUrlTask.name',
		'description'      => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xlf:getUrlTask.description',
		'additionalFields' => 'WebentwicklerAt\\SchedulerHttp\\Task\\GetUrlTaskAdditionalFieldProvider',
	);

	// XCLASS scheduler
	$extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);
	if (is_array($extConf) && array_key_exists('execManual', $extConf) && $extConf['execManual'] && TYPO3_MODE == 'FE') {
		$GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Scheduler\\Scheduler'] = array(
			'className' => 'WebentwicklerAt\\SchedulerHttp\\Xclass\\Scheduler',
		);
	}
};

$boot($_EXTKEY);
unset($boot);
