<?php
/**
 * Created by JetBrains PhpStorm.
 * User: federico
 * Date: 15/10/12
 * Time: 12:52
 * To change this template use File | Settings | File Templates.
 */

$TYPO3_CONF_VARS['EXTCONF']['t3registration']['init'][] = 'EXT:t3registration_test/hooks/class.tx_t3registrationtest_hooks.php:tx_t3registrationtest_hooks->test';
$TYPO3_CONF_VARS['FE']['eID_include']['t3registration_test'] =  'EXT:t3registration_test/library/class.tx_t3registrationtest_eid.php';
?>