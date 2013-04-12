<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

  ## Adding alternative output engine to eID mechanism
$TYPO3_CONF_VARS['FE']['eID_include'][$_EXTKEY] = 'EXT:' . $_EXTKEY . '/eid/class.tx_schedulerhttp_eid.php';

  ## Adding scheduler task
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['tx_schedulerhttp_geturl'] = array(
    'extension'        => $_EXTKEY,
    'title'            => 'Get URL',
    'description'      => 'Requests configured URL',
    'additionalFields' => 'tx_schedulerhttp_geturl_additionalfieldprovider',
);

  ## XLASS scheduler
if (TYPO3_MODE == 'FE') {
	$GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/scheduler/class.tx_scheduler.php'] = t3lib_extMgm::extPath($_EXTKEY, 'class.ux_tx_scheduler.php');
}
