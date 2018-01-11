<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "scheduler_http".
 *
 * Auto generated | Identifier: e2612acb18a62dfb12d9a6fa8d717f20
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
	'title' => 'Scheduler HTTP',
	'description' => 'Invoke scheduler via HTTP-Request and add scheduler tasks doing GET-Requests.',
	'category' => 'misc',
	'version' => '1.3.4',
	'state' => 'stable',
	'uploadfolder' => false,
	'createDirs' => '',
	'clearCacheOnLoad' => 0,
	'author' => 'Gernot Leitgab',
	'author_company' => 'Webentwickler.at',
	'constraints' => 
	array (
		'depends' => 
		array (
			'typo3' => '6.2.0-8.7.99',
			'scheduler' => '6.2.0-8.7.99',
		),
		'conflicts' => 
		array (
		),
		'suggests' => 
		array (
		),
	),
	'_md5_values_when_last_written' => 'a:34:{s:9:"ChangeLog";s:4:"5543";s:8:"Classes/";s:4:"d41d";s:12:"Classes/Eid/";s:4:"d41d";s:32:"Classes/Eid/SchedulerHttpEid.php";s:4:"df81";s:13:"Classes/Task/";s:4:"d41d";s:27:"Classes/Task/GetUrlTask.php";s:4:"4967";s:50:"Classes/Task/GetUrlTaskAdditionalFieldProvider.php";s:4:"6480";s:15:"Classes/Xclass/";s:4:"d41d";s:28:"Classes/Xclass/Scheduler.php";s:4:"ac08";s:14:"Documentation/";s:4:"d41d";s:24:"Documentation/ChangeLog/";s:4:"d41d";s:33:"Documentation/ChangeLog/Index.rst";s:4:"48a8";s:26:"Documentation/Includes.txt";s:4:"c83c";s:23:"Documentation/Index.rst";s:4:"da8e";s:27:"Documentation/Introduction/";s:4:"d41d";s:36:"Documentation/Introduction/Index.rst";s:4:"b5df";s:28:"Documentation/KnownProblems/";s:4:"d41d";s:37:"Documentation/KnownProblems/Index.rst";s:4:"0acb";s:26:"Documentation/Settings.cfg";s:4:"0cd3";s:23:"Documentation/ToDoList/";s:4:"d41d";s:32:"Documentation/ToDoList/Index.rst";s:4:"1053";s:19:"Documentation/User/";s:4:"d41d";s:28:"Documentation/User/Index.rst";s:4:"ffc5";s:7:"LICENSE";s:4:"b234";s:10:"Resources/";s:4:"d41d";s:18:"Resources/Private/";s:4:"d41d";s:27:"Resources/Private/Language/";s:4:"d41d";s:43:"Resources/Private/Language/de.locallang.xlf";s:4:"a338";s:40:"Resources/Private/Language/locallang.xlf";s:4:"547e";s:13:"composer.json";s:4:"ed6f";s:21:"ext_conf_template.txt";s:4:"56b5";s:12:"ext_icon.gif";s:4:"97d0";s:12:"ext_icon.png";s:4:"adf2";s:17:"ext_localconf.php";s:4:"850b";}',
	'clearcacheonload' => false,
	'author_email' => NULL,
);

?>