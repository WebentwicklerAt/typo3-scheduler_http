<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Scheduler HTTP',
    'description' => 'Invoke scheduler via HTTP-Request and add scheduler tasks doing GET-Requests.',
    'category' => 'misc',
    'version' => '2.0.0',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'author' => 'Gernot Leitgab',
    'author_company' => 'Webentwickler.at',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-9.5.99',
            'scheduler' => '9.5.0-9.5.99',
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
