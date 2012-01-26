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

if (!defined ('PATH_typo3conf')) {
	die ('Access denied: eID only.');
}

class tx_schedulerhttp_eid {
	var $prefixId      = 'tx_schedulerhttp_eid';		// Same as class name
	var $scriptRelPath = 'eid/class.tx_schedulerhttp_eid.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'scheduler_http';	// The extension key.
	
	function eid_main() {
		$this->conf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$this->extKey]);
		
		$execCmd = PATH_typo3 . 'cli_dispatch.phpsh scheduler';
		if (is_array($this->conf) && array_key_exists('debug', $this->conf) && strlen($this->conf['execCmd'])) {
			$execCmd = str_replace('###CLI_SCRIPT###', $execCmd, $this->conf['execCmd']);
		}
		
		exec($execCmd, $output, $return_var);
		$output['return_var'] = $return_var;
		
		if (is_array($this->conf) && array_key_exists('debug', $this->conf) && $this->conf['debug']) {
			t3lib_utility_Debug::debug($output, $this->extKey);
		}
		if (TYPO3_DLOG) {
			t3lib_div::devLog(t3lib_div::arrayToLogString($output), $this->extKey);
		}
	}
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/scheduler_http/eid/class.tx_schedulerhttp_eid.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/scheduler_http/eid/class.tx_schedulerhttp_eid.php']);
}

$tx_schedulerhttp_eid = t3lib_div::makeInstance('tx_schedulerhttp_eid');
$tx_schedulerhttp_eid->eid_main();
