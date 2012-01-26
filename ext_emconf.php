<?php

########################################################################
# Extension Manager/Repository config file for ext "scheduler_http".
#
# Auto generated 22-01-2012 09:43
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Scheduler via HTTP',
	'description' => 'Invoke scheduler via HTTP-Request',
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
	'version' => '1.1.0',
	'constraints' => array(
		'depends' => array(
			'scheduler' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:6:{s:21:"ext_conf_template.txt";s:4:"048e";s:12:"ext_icon.gif";s:4:"97d0";s:17:"ext_localconf.php";s:4:"b455";s:17:"doc/manual.de.sxw";s:4:"6a2d";s:14:"doc/manual.sxw";s:4:"358f";s:34:"eid/class.tx_schedulerhttp_eid.php";s:4:"ace3";}',
	'suggests' => array(
	),
);

?>