<?php
namespace WebentwicklerAt\SchedulerHttp\Eid;

use Exception;
use OutOfBoundsException;
use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Scheduler\Task\AbstractTask;
use UnexpectedValueException;

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

if (!defined('PATH_typo3conf')) {
    die ('Access denied: eID only.');
}

/**
 * Scheduler task doing GET-Requests.
 *
 * @author Gernot Leitgab <https://webentwickler.at>
 */
class SchedulerHttpEid
{
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
    public function eid_main()
    {
        $this->settings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$this->extKey]);
        if (
            is_array($this->settings)
            && array_key_exists('accessList', $this->settings)
            && $this->isAccessAllowed()
        ) {
            $taskId = (int)GeneralUtility::_GP('i');
            if (
                is_array($this->settings)
                && array_key_exists('allowForce', $this->settings)
                && $this->settings['allowForce']
            ) {
                $force = (bool)GeneralUtility::_GP('f');
            } else {
                $force = false;
            }
            $output = $this->execCli($taskId, $force);
        } else {
            $output = sprintf(
                LocalizationUtility::translate('access.denied', $this->extKey),
                GeneralUtility::getIndpEnv('REMOTE_ADDR')
            );
        }

        if (
            is_array($this->settings)
            && array_key_exists('debug', $this->settings)
            && $this->settings['debug']
        ) {
            DebugUtility::debug($output, $this->extKey);
            $logger = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Log\\LogManager')->getLogger(__CLASS__);
            $logger->log(
                LogLevel::INFO,
                $output
            );
        }
    }

    /**
     * Returns if accessing host is within access list
     *
     * @return bool
     */
    protected function isAccessAllowed()
    {
        $accessList =
            GeneralUtility::cmpIP(
            GeneralUtility::getIndpEnv('REMOTE_ADDR'),
            $this->settings['accessList']
            )
            || GeneralUtility::cmpFQDN(
                GeneralUtility::getIndpEnv('REMOTE_ADDR'),
                $this->settings['accessList']
            );

        $accessToken = true;
        if (
            array_key_exists('accessToken', $this->settings)
            && strlen($this->settings['accessToken'])
        ) {
            if (GeneralUtility::_GET('access_token') == $this->settings['accessToken']) {
                $accessToken = true;
            } else {
                $accessToken = false;
            }
        }

        return $accessList && $accessToken;
    }

    /**
     * Executes scheduler through shell
     *
     * @param integer $taskId ID of scheduler task
     * @param boolean $force Signals if execution should be forced
     * @return mixed
     */
    protected function execCli($taskId, $force)
    {
        $execCmd = PATH_typo3 . 'cli_dispatch.phpsh scheduler';
        if ($taskId > 0) {
            $execCmd .= ' -i ' . $taskId;

            if ($force) {
                $execCmd .= ' -f';
            }
        }
        $execCmd .= ' 2>&1';

        if (is_array($this->settings) && array_key_exists('execCmd',
                $this->settings) && strlen($this->settings['execCmd'])) {
            $execCmd = str_replace('###CLI_SCRIPT###', $execCmd, $this->settings['execCmd']);
        }

        exec($execCmd, $output, $return_var);
        $output['return_var'] = $return_var;

        return $output;
    }
}

call_user_func(function () {
    $schedulerHttpEid = GeneralUtility::makeInstance(SchedulerHttpEid::class);
    $schedulerHttpEid->eid_main();
});
