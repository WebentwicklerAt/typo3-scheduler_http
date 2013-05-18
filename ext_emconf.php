<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "scheduler_http".
 *
 * Auto generated 18-05-2013 10:30
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Scheduler HTTP',
	'description' => 'Invoke scheduler via HTTP-Request and add scheduler tasks doing a GET-Request.',
	'category' => 'misc',
	'author' => 'Gernot Leitgab',
	'author_email' => 'leitgab@gmail.com',
	'shy' => '',
	'dependencies' => 'scheduler',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '1.2.1',
	'constraints' => array(
		'depends' => array(
			'scheduler' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:12:{s:9:"ChangeLog";s:4:"439f";s:25:"class.ux_tx_scheduler.php";s:4:"d63e";s:16:"ext_autoload.php";s:4:"b1c2";s:21:"ext_conf_template.txt";s:4:"7abb";s:12:"ext_icon.gif";s:4:"97d0";s:17:"ext_localconf.php";s:4:"94ec";s:13:"locallang.xml";s:4:"b492";s:17:"doc/manual.de.sxw";s:4:"838a";s:14:"doc/manual.sxw";s:4:"1f04";s:34:"eid/class.tx_schedulerhttp_eid.php";s:4:"cdbd";s:39:"tasks/class.tx_schedulerhttp_geturl.php";s:4:"a114";s:63:"tasks/class.tx_schedulerhttp_geturl_additionalfieldprovider.php";s:4:"752d";}',
	'suggests' => array(
	),
);

?>