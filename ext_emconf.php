<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Scheduler HTTP',
    'description' => 'Invoke scheduler via HTTP-Request and add scheduler tasks doing GET-Requests.',
    'category' => 'misc',
    'version' => '13.0.0',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'author' => 'Gernot Leitgab',
    'author_company' => 'Webentwickler.at',
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-13.4.99',
            'scheduler' => '13.4.0-13.4.99',
        ],
        'conflicts' => [
        ],
        'suggests' => [
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'WebentwicklerAt\\SchedulerHttp\\' => 'Classes/',
        ],
    ],
];
