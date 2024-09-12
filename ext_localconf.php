<?php

declare(strict_types=1);

defined('TYPO3') or die();

(static function (): void {
    $_EXTKEY = 'scheduler_http';

    // Adding alternative output engine to eID mechanism
    $GLOBALS['TYPO3_CONF_VARS']['FE']['eID_include'][$_EXTKEY] = 'EXT:' . $_EXTKEY . '/Classes/Eid/SchedulerHttpEid.php';

    // Adding scheduler task
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][\WebentwicklerAt\SchedulerHttp\Task\GetUrlTask::class] = [
        'extension' => $_EXTKEY,
        'title' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xlf:getUrlTask.name',
        'description' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang.xlf:getUrlTask.description',
        'additionalFields' => \WebentwicklerAt\SchedulerHttp\Task\GetUrlTaskAdditionalFieldProvider::class,
    ];
})();
