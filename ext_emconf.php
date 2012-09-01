<?php

########################################################################
# Extension Manager/Repository config file for ext "test_t3registration".
#
# Auto generated 12-12-2011 23:19
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'test T3Registration',
	'description' => 'T3Registration Test environment extension',
	'category' => 'fe',
	'author' => 'Federico',
	'author_email' => 'federico@bernardin.it',
	'shy' => '',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.1.0',
	'constraints' => array(
		'depends' => array(
            't3registration'
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:8:{s:9:"ChangeLog";s:4:"91e7";s:10:"README.txt";s:4:"ee2d";s:12:"ext_icon.gif";s:4:"1bdc";s:14:"ext_tables.php";s:4:"cfcf";s:14:"ext_tables.sql";s:4:"2cde";s:16:"locallang_db.xml";s:4:"d241";s:19:"doc/wizard_form.dat";s:4:"1fb0";s:20:"doc/wizard_form.html";s:4:"870c";}',
);

?>