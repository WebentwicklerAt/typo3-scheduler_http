<?php 

defined('TYPO3') or die;

use TYPO3\CMS\Core\Core\Environment;

(function () {
    $extensionKey = "scheduler_http";

    // Adding scheduler task
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['WebentwicklerAt\\SchedulerHttp\\Task\\GetUrlTask'] = [
        'extension'        => $extensionKey,
        'title'            => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang.xlf:getUrlTask.name',
        'description'      => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang.xlf:getUrlTask.description',
        'additionalFields' => 'WebentwicklerAt\\SchedulerHttp\\Task\\GetUrlTaskAdditionalFieldProvider',
    ];

    // XCLASS scheduler
    $extConf = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS'][$extensionKey] ?? [];
    if (is_array($extConf) && array_key_exists('execManual', $extConf) && $extConf['execManual'] && Environment::getContext()->isFrontend()) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects']['TYPO3\\CMS\\Scheduler\\Scheduler'] = [
            'className' => 'WebentwicklerAt\\SchedulerHttp\\Xclass\\Scheduler',
        ];
    }
})();

