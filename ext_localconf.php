<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

  ## Adding alternative output engine to eID mechanism
$TYPO3_CONF_VARS['FE']['eID_include'][$_EXTKEY] = 'EXT:'.$_EXTKEY.'/eid/class.tx_schedulerhttp_eid.php';
