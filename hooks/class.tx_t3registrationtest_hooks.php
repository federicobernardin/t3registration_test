<?php
/**
 * Created by JetBrains PhpStorm.
 * User: federico
 * Date: 15/10/12
 * Time: 12:51
 * To change this template use File | Settings | File Templates.
 */
class tx_t3registrationtest_hooks {

    public function test($params,$pObj){
        /*$mail = t3lib_div::makeInstance('tx_t3registrationtest_mail');
        $mail->initialize();
        $mail->searchForIncomingEmailByGUID('xxx-xxx-xxx');*/

        if(is_array($_GET['tx_t3registrationtest_pi1']) && count($_GET['tx_t3registrationtest_pi1'])){
            $step = $_GET['tx_t3registrationtest_pi1']['step'];
            $enable = $_GET['tx_t3registrationtest_pi1']['enable'];
            $failed = (isset($_GET['tx_t3registrationtest_pi1']['failed']))?true:false;
            if($enable){
                switch($step){
                    case 'evaluation':
                        $evaluationTest = (isset($_GET['tx_t3registrationtest_pi1']['eval_test']))?$_GET['tx_t3registrationtest_pi1']['eval_test']:'';
                        switch ($evaluationTest){
                            case 'inDate':
                                $params['conf']['fieldConfiguration.']['tx_t3registrationtest_date.']['config.']['date.']['maxDate'] = '1.1.2010';
                                $params['conf']['fieldConfiguration.']['tx_t3registrationtest_date.']['config.']['date.']['maxDate'] = '1.10.2009';
                                $params['conf']['fieldConfiguration.']['tx_t3registrationtest_date.']['config.']['date.']['strftime'] = 'd.m.Y';
                                if($failed){
                                    $params['piVars'] = array('tx_t3registrationtest_date' => '1.2.2010');
                                }
                                else{
                                    $params['piVars'] = array('tx_t3registrationtest_date' => '1.12.2009');
                                }
                                break;
                            case 'inFuture':
                                $params['conf']['fieldConfiguration.']['tx_t3registrationtest_date.']['config.']['date.']['dateHasToBeIn'] = 'future';
                                if($failed){
                                    $params['piVars'] = array('tx_t3registrationtest_date' => '1.2.2010');
                                }
                                else{
                                    $params['piVars'] = array('tx_t3registrationtest_date' => '1.2.2010');
                                }
                                break;
                            case 'inPast':
                                $params['conf']['fieldConfiguration.']['tx_t3registrationtest_date.']['config.']['date.']['dateHasToBeIn'] = 'past';
                                if($failed){
                                    $params['piVars'] = array('tx_t3registrationtest_date' => '1.2.2050');
                                }
                                else{
                                    $params['piVars'] = array('tx_t3registrationtest_date' => '1.2.2010');
                                }
                                break;
                            default:
                                $params['piVars'] = array(
                                    'email' => 'email@noncorretta',
                                    'password' => 'pluto',
                                    'passwordTwice' => 'iiiii',
                                    'tx_t3registrationtest_date' => 'hhhhh',
                                    'submitted' => 1
                                );
                        }
                }
            }
            $params['conf']['errors.']['classError'] = 'errorT3RegistrationClass';
            $params['conf']['templateFile'] = 'EXT:t3registration_test/res/template_test.html';
        }
    }

}
