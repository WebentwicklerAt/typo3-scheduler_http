<?php
namespace WebentwicklerAt\SchedulerHttp\Eid;

use TYPO3\CMS\Core\Utility\GeneralUtility;

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

if (!defined ('PATH_typo3conf')) {
	die ('Access denied: eID only.');
}

/**
 * Scheduler task doing GET-Requests.
 *
 * @author Gernot Leitgab <typo3@webentwickler.at>
 */
class SchedulerHttpEid {
	/**
	 * Extension key
	 *
	 * @var string
	 */
	protected $extKey = 'scheduler_http';

	/**
	 * Settings
	 *
	 * @var array
	 */
	protected $settings;

	/**
	 * Main eID method
	 *
	 * @return void
	 */
	public function eid_main() {
		$this->settings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$this->extKey]);

		if (is_array($this->settings) && array_key_exists('accessList', $this->settings) && $this->isAccessAllowed()) {
			$taskId = (int)GeneralUtility::_GP('i');
			if (is_array($this->settings) && array_key_exists('allowForce', $this->settings) && $this->settings['allowForce']) {
				$force = (bool)GeneralUtility::_GP('f');
			}
			else {
				$force = FALSE;
			}

			if (is_array($this->settings) && array_key_exists('execManual', $this->settings) && $this->settings['execManual']) {
				$output = $this->execManual($taskId, $force);
			} else {
				$output = $this->execCli($taskId, $force);
			}
		}
		else {
			$output = sprintf(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('access.denied', $this->extKey), GeneralUtility::getIndpEnv('REMOTE_ADDR'));
		}

		if (is_array($this->settings) && array_key_exists('debug', $this->settings) && $this->settings['debug']) {
			\TYPO3\CMS\Core\Utility\DebugUtility::debug($output, $this->extKey);

			$logger = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Log\\LogManager')->getLogger(__CLASS__);
			$logger->log(
				\TYPO3\CMS\Core\Log\LogLevel::INFO,
				$output
			);
		}
		if (TYPO3_DLOG) {
			GeneralUtility::devLog(GeneralUtility::arrayToLogString($output), __CLASS__);
		}
	}

	/**
	 * Returns if accessing host is within access list
	 *
	 * @return bool
	 */
	protected function isAccessAllowed() {
		$accessList = GeneralUtility::cmpIP(GeneralUtility::getIndpEnv('REMOTE_ADDR'), $this->settings['accessList']) ||
			GeneralUtility::cmpFQDN(GeneralUtility::getIndpEnv('REMOTE_ADDR'), $this->settings['accessList']);

		$accessToken = true;
		if (array_key_exists('accessToken', $this->settings) && strlen($this->settings['accessToken'])) {
			if (GeneralUtility::_GET('access_token') == $this->settings['accessToken']) {
				$accessToken = true;
			}
			else {
				$accessToken = false;
			}
		}

		return $accessList && $accessToken;
	}

	/**
	 * Executes scheduler the same way it is done in backend module
	 *
	 * @param integer $taskId ID of scheduler task
	 * @param boolean $force Signals if execution should be forced
	 * @return array
	 */
	protected function execManual($taskId, $force) {
		// setup
		$output = array();

		$LANG = GeneralUtility::makeInstance('TYPO3\\CMS\\Lang\\LanguageService');
		$LANG->init($GLOBALS['BE_USER'] ? $GLOBALS['BE_USER']->uc['lang'] : 'default');
		$LANG->includeLLFile(PATH_site . 'typo3/sysext/scheduler/mod1/locallang.xlf');

		$scheduler = GeneralUtility::makeInstance('TYPO3\\CMS\\Scheduler\\Scheduler');

		// code taken, merged and modified from EXT:scheduler/Class/Controller/SchedulerModuleController.php and EXT:scheduler/cli/scheduler_cli_dispatch.php
		if ($taskId > 0) {
			// Force the execution of the task even if it is disabled or no execution scheduled
			if ($force) {
				$task = $scheduler->fetchTask($taskId);
			} else {
				$whereClause = 'uid = ' . $taskId . ' AND nextexecution != 0 AND nextexecution <= ' . $GLOBALS['EXEC_TIME'];
				list($task) = $scheduler->fetchTasksWithCondition($whereClause);
			}
			if ($scheduler->isValidTaskObject($task)) {
				$class = get_class($task);
				try {
					$result = $scheduler->executeTask($task);
					if ($result) {
						$output[] = sprintf($LANG->getLL('msg.executed'), $class);
					}
					else {
						$output[] = sprintf($LANG->getLL('msg.notExecuted'), $class);
					}
				} catch (\Exception $e) {
					$output[] = sprintf($LANG->getLL('msg.executionFailed'), $class, $e->getMessage());
				}
				// Record the run in the system registry
				$scheduler->recordLastRun('manual');
			}
		} else {
			// Loop as long as there are tasks
			do {
				// Try getting the next task and execute it
				// If there are no more tasks to execute, an exception is thrown by \TYPO3\CMS\Scheduler\Scheduler::fetchTask()
				try {
					/** @var $task \TYPO3\CMS\Scheduler\Task\AbstractTask */
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
					} catch (\Exception $e) {
						$output[] = sprintf($LANG->getLL('msg.executionFailed'), $class, $e->getMessage());
						continue;
					}
				} catch (\OutOfBoundsException $e) {
					$hasTask = FALSE;
				} catch (\UnexpectedValueException $e) {
					$output[] = sprintf($LANG->getLL('msg.executionFailed'), $class, $e->getMessage());
					continue;
				}
			} while ($hasTask);
			// Record the run in the system registry
			$scheduler->recordLastRun('manual');
		}

		return $output;
	}

	/**
	 * Executes scheduler through shell
	 *
	 * @param integer $taskId ID of scheduler task
	 * @param boolean $force Signals if execution should be forced
	 * @return mixed
	 */
	protected function execCli($taskId, $force) {
		$execCmd = PATH_typo3 . 'cli_dispatch.phpsh scheduler';
		if ($taskId > 0) {
			$execCmd .= ' -i' . $taskId;

			if ($force) {
				$execCmd .= ' -f';
			}
		}
		$execCmd .= ' 2>&1';

		if (is_array($this->settings) && array_key_exists('execCmd', $this->settings) && strlen($this->settings['execCmd'])) {
			$execCmd = str_replace('###CLI_SCRIPT###', $execCmd, $this->settings['execCmd']);
		}

		exec($execCmd, $output, $return_var);
		$output['return_var'] = $return_var;

		return $output;
	}
}

call_user_func(function () {
	$schedulerHttpEid = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('WebentwicklerAt\\SchedulerHttp\\Eid\\SchedulerHttpEid');
	$schedulerHttpEid->eid_main();
});
