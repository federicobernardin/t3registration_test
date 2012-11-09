<?php
/**
 * Created by JetBrains PhpStorm.
 * User: federico
 * Date: 15/10/12
 * Time: 16:07
 * To change this template use File | Settings | File Templates.
 */
class tx_t3registrationtest_eid {

    public function main(){
        if($_GET['enabletest'] == 1){
            $step = $_GET['step'];
            $evaluationTest = $_GET['eval_test'];
            $configuration = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['t3registration_test']);
            $url = t3lib_div::locationHeaderUrl('/?id=' .  $configuration['pageId']);
            echo tx_t3registrationtest_http::sendHTTP($url,array(),array('tx_t3registrationtest_pi1[enable]' => '1', 'tx_t3registrationtest_pi1[step]' => $step, 'tx_t3registrationtest_pi1[eval_test]' => $evaluationTest));

        }
    }

}

$eid = new tx_t3registrationtest_eid();
$eid->main();
