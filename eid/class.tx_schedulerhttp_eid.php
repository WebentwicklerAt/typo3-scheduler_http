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
	
	var $prefixId      = 'tx_schedulerhttp_eid';
	var $scriptRelPath = 'eid/class.tx_schedulerhttp_eid.php';
	var $extKey        = 'scheduler_http';
	
	public function eid_main() {
		$this->conf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$this->extKey]);
		
		if (is_array($this->conf) && array_key_exists('execManual', $this->conf) && $this->conf['execManual']) {
			$output = $this->execManual();
		}
		else {
			$output = $this->execCli();
		}
		
		if (is_array($this->conf) && array_key_exists('debug', $this->conf) && $this->conf['debug']) {
			t3lib_utility_Debug::debug($output, $this->extKey);
		}
		if (TYPO3_DLOG) {
			t3lib_div::devLog(t3lib_div::arrayToLogString($output), $this->extKey);
		}
	}
	
	protected function execManual() {
		// setup
		$output = array();
		tslib_eidtools::connectDB();
		
		$LANG = t3lib_div::makeInstance('language');
		$LANG->init($GLOBALS['BE_USER'] ? $GLOBALS['BE_USER']->uc['lang'] : 'default');
		$LANG->includeLLFile(PATH_site . 'typo3/sysext/scheduler/mod1/locallang.xml');
		
		require_once PATH_site . 'typo3/sysext/scheduler/class.tx_scheduler.php';
		require_once PATH_site . 'typo3/sysext/scheduler/class.tx_scheduler_croncmd.php';
		require_once PATH_site . 'typo3/sysext/scheduler/class.tx_scheduler_croncmd_normalize.php';
		require_once PATH_site . 'typo3/sysext/scheduler/class.tx_scheduler_execution.php';
		require_once PATH_site . 'typo3/sysext/scheduler/class.tx_scheduler_failedexecutionexception.php';
		require_once PATH_site . 'typo3/sysext/scheduler/class.tx_scheduler_task.php';
		$scheduler = t3lib_div::makeInstance('tx_scheduler');
		
		// code taken, merged and modified from EXT:scheduler/class.tx_scheduler_module.php and EXT:scheduler/cli/scheduler_cli_dispatch.php
		$hasTask = TRUE;
		do {
			try {
				$task = $scheduler->fetchTask();
				$class = get_class($task);
				
				$hasTask = TRUE;
				try {
					$result = $scheduler->executeTask($task);
					if ($result) {
						$output[] = sprintf($LANG->getLL('msg.executed'), $class);
					}
					else {
						$output[] = sprintf($LANG->getLL('msg.notExecuted'), $class);
					}
				}
				catch (Exception $e) {
					$output[] = sprintf($LANG->getLL('msg.executionFailed'), $class, $e->getMessage());
					continue;
				}
			}
				// There are no more tasks, quit the run
			catch (OutOfBoundsException $e) {
				$hasTask = FALSE;
			}
				// The task object was not valid
			catch (UnexpectedValueException $e) {
				$output[] = sprintf($LANG->getLL('msg.executionFailed'), $class, $e->getMessage());
				continue;
			}
		} while ($hasTask);
		
		$scheduler->recordLastRun('manual');
		
		return $output;
	}
	
	protected function execCli() {
		$execCmd = PATH_typo3 . 'cli_dispatch.phpsh scheduler 2>&1';
		if (is_array($this->conf) && array_key_exists('execCmd', $this->conf) && strlen($this->conf['execCmd'])) {
			$execCmd = str_replace('###CLI_SCRIPT###', $execCmd, $this->conf['execCmd']);
		}
		
		exec($execCmd, $output, $return_var);
		$output['return_var'] = $return_var;
		
		return $output;
	}
	
}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/scheduler_http/eid/class.tx_schedulerhttp_eid.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/scheduler_http/eid/class.tx_schedulerhttp_eid.php']);
}

$tx_schedulerhttp_eid = t3lib_div::makeInstance('tx_schedulerhttp_eid');
$tx_schedulerhttp_eid->eid_main();
