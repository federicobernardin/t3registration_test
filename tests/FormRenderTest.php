<?php
/***************************************************************
 * Copyright notice
 *
 * (c) 2012 Federico Bernardin <federico@bernardin.it>
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

class FormRenderTest  extends tx_phpunit_testcase {

    /**
     * @var Tx_Phpunit_Framework
     */
    protected $fixture;

    /**
     * @var t3lib_TSTemplate
     */
    protected $tstemplate;

    /**
     * @var tslib_cObj
     */
    protected $cObj;


    /**
     * @var DOMXPath
     */
    protected $xpath;

    /**
     * @var DOMDocument
     */
    protected $doc;

    /**
     * @var DOMNode
     */
    protected $body;

    /**
     * @var string
     */
    protected $errorClass = 'errorT3RegistrationClass';

    /**
     * @var array configuration array
     */
    protected $conf;

    public function setUp() {
        $this->fixture = new Tx_Phpunit_Framework('fe_users');
        $this->fixture->cleanUp(TRUE);
        $this->fixture->createFakeFrontEnd();
        $this->conf = $this->generateTyposcriptSetup();
        //variable should be included at each cycle
        require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/CObjData.php'));
        $this->initializeCobj($tt_contentData);
        require_once(t3lib_extMgm::extPath('t3registration', 'pi1/class.tx_t3registration_pi1.php'));
    }

    public function tearDown(){
        $this->fixture->discardFakeFrontEnd();
        $this->fixture->cleanUp(TRUE);
        unset($this->fixture);
        unset($this->conf);
        unset($this->cObj);
        unset($this->doc);
        unset($this->body);
        unset($this->xpath);
    }


    /**
     * Test standard HTML Output
     * @test
     */
    public function CallExtensionCorretlyWithDefaultBehaviorShouldReturnBasicForm() {
        $setup[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic.ts'));
        $this->conf = $this->generateTyposcriptSetup($setup);
        $html = $this->loadExtension();
        $this->body = $this->getDomRootFromHTML($html);
        $this->assertXpath('//form',1);
        $this->assertXpath('/html/body/div/form/div[@id=\'FirstNameField\']/label',1,'First name:');
        $this->assertXpath('/html/body/div/form/div[@id=\'LastNameField\']/label',1,'Last name:');
        $this->assertXpath('/html/body/div/form/div[@id=\'emailField\']/label',1,'Email:');
        $this->assertXpath('/html/body/div/form/div[@id=\'passwordField\']/label',1,'Password:');
        $this->assertXpath('/html/body/div/form/div[@id=\'passwordTwiceField\']/label',1,'Repeat password');
        $this->assertXpath('/html/body/div/form/div[@id=\'tx_t3registrationtest_date_field\']/label',1,'Data di nascita');
        $this->assertXpath('/html/body/div/form/div[@id=\'tx_t3registrationtest_select_field\']/label',1,'select');
        $this->assertXpath('/html/body/div/form/div[@id=\'tx_t3registrationtest_radio_field\']/label',1,'radio');
        $this->assertXpath('/html/body/div/form/div[@id=\'tx_t3registrationtest_check_field\']/label',1,'check');
        $this->assertXpath('/html/body/div/form/div[@id=\'tx_t3registrationtest_checkmultiple_field\']/label',1,'checkmultiple');
        $this->assertXpath('/html/body/div/form/div[@id=\'image_field\']/label',1,'Image:');
        $this->assertXpath('/html/body/div/form/div[@id=\'tx_t3registrationtest_procfunc_field\']/label',1,'Proc Func Field');
        $this->assertXpath('/html/body/div/form/input[@name=\'tx_t3registration_pi1[tx_phpunit_is_dummy_record]\']',1);
    }

    /***********************EVALUATION RULE**************************/

    /**
     * @test
     */
    public function ExecutesASubmitWithEmptyFieldsShouldBeRaiseSomeErrorsAlsoSingleError() {
        $setup[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic.ts'));
        $setup[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/TestFieldError.ts'));
        $constant[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic_const.ts'));
        $this->conf = $this->generateTyposcriptSetup($setup,$constant);
        $_POST['tx_t3registration_pi1']['submitted'] = 1;
        $html = $this->loadExtension();
        /*debug($html);
        exit;*/
        $this->body = $this->getDomRootFromHTML($html);
        $this->checkError('LastNameField','Surname is not correct');
        $this->checkError('FirstNameField','First should be a number');
        $this->checkError('passwordField','Password is not correct');
        $this->checkError('emailField','Email is not correct');
    }

    /**
     * @test
     */
    public function ExecutesASubmitWithRegularExpressionOnLastNameShouldBeRaiseAnError() {
        $setup[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic.ts'));
        $setup[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/TestFieldError.ts'));
        $constant[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic_const.ts'));
        $this->conf = $this->generateTyposcriptSetup($setup,$constant);
        $_POST['tx_t3registration_pi1']['submitted'] = 1;
        $html = $this->loadExtension();
        $this->body = $this->getDomRootFromHTML($html);
        $this->checkError('LastNameField','Surname is not correct');
    }

    /**
     * @test
     */
    public function ExecutesASubmitWithRegularExpressionOnLastNameWithSingleErrorEvaluateShouldBeRaiseAnError() {
        $setup[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic.ts'));
        $setup[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/TestFieldError.ts'));
        $constant[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic_const.ts'));
        $this->conf = $this->generateTyposcriptSetup($setup,$constant);
        $this->conf['fieldConfiguration.']['last_name.']['singleErrorEvaluate'] = 1;
        $_POST['tx_t3registration_pi1']['submitted'] = 1;
        $html = $this->loadExtension();
        $this->body = $this->getDomRootFromHTML($html);
        $this->checkError('LastNameField','Regexp Error');
    }

    /**
     * test for alfa and numeric
     * @test
     */
    public function ExecutesASubmitWithIsStringAndIsNumericOnFirstNameShouldBeRaiseAnError() {
        $setup[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic.ts'));
        $setup[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/TestFieldError.ts'));
        $constant[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic_const.ts'));
        $this->conf = $this->generateTyposcriptSetup($setup,$constant);
        $_POST['tx_t3registration_pi1']['submitted'] = 1;
        $this->conf['fieldConfiguration.']['first_name.'] = $this->conf['lib.']['alpha.'];
        $this->conf['fieldConfiguration.']['first_name.']['singleErrorEvaluate'] = 0;
        $_POST['tx_t3registration_pi1']['first_name'] = '10034';
        $html = $this->loadExtension();
        $this->body = $this->getDomRootFromHTML($html);
        $this->checkError('FirstNameField','First name is not correct');
        $this->conf['fieldConfiguration.']['first_name.'] = $this->conf['lib.']['int.'];
        $this->conf['fieldConfiguration.']['first_name.']['singleErrorEvaluate'] = 0;
        $_POST['tx_t3registration_pi1']['submitted'] = 1;
        $_POST['tx_t3registration_pi1']['first_name'] = 'aaaaa';
        $html = $this->loadExtension();
        $this->body = $this->getDomRootFromHTML($html);
        $this->checkError('FirstNameField','First name is not correct');
    }



    /**
     * test for unique and uniqueInPid
     * @test
     */
    public function ExecutesASubmitWithIsUniqueAndIsUniqueInPidOnEmailShouldBeRaiseAnError() {
        $setup[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic.ts'));
        $setup[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/TestFieldError.ts'));
        $constant[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic_const.ts'));
        $this->conf = $this->generateTyposcriptSetup($setup,$constant);
        require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/piVarsFixture.php'));
        $user = $userCorrectForDatabaseInsertion;
        $user['pid'] = 340;
        $this->fixture->createFrontEndUser('',$user);
        $_POST['tx_t3registration_pi1']['submitted'] = 1;
        $this->conf['fieldConfiguration.']['email.'] = $this->conf['lib.']['unique.'];
        $this->conf['fieldConfiguration.']['email.']['singleErrorEvaluate'] = 0;
        $_POST['tx_t3registration_pi1']['email'] = $user['email'];
        $html = $this->loadExtension();
        $this->body = $this->getDomRootFromHTML($html);
        $this->checkError('emailField','Email is not correct');
        $this->conf['fieldConfiguration.']['email.'] = $this->conf['lib.']['uniqueInPid.'];
        $this->conf['fieldConfiguration.']['email.']['singleErrorEvaluate'] = 0;
        $_POST['tx_t3registration_pi1']['submitted'] = 1;
        $html = $this->loadExtension();
        $this->body = $this->getDomRootFromHTML($html);
        $this->checkError('emailField','Email is not correct');
    }

    /**
     * test for date
     * @test
     */
    public function ExecutesASubmitWithDateEvaluationOndateFieldShouldBeRaiseAnError() {
        $setup[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic.ts'));
        $setup[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/TestFieldError.ts'));
        $constant[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic_const.ts'));
        $this->conf = $this->generateTyposcriptSetup($setup,$constant);
        $_POST['tx_t3registration_pi1']['submitted'] = 1;
        $this->conf['fieldConfiguration.']['tx_t3registrationtest_date.'] = $this->conf['lib.']['date.'];
        $this->conf['fieldConfiguration.']['tx_t3registrationtest_date.']['singleErrorEvaluate'] = 0;
        $_POST['tx_t3registration_pi1']['tx_t3registrationtest_date'] = '1/1/2012';
        $html = $this->loadExtension();
        $this->body = $this->getDomRootFromHTML($html);
        $this->checkError('tx_t3registrationtest_date_field','Date is not correct');
        $this->conf['fieldConfiguration.']['tx_t3registrationtest_date.'] = $this->conf['lib.']['dateWithMax.'];
        $this->conf['fieldConfiguration.']['tx_t3registrationtest_date.']['singleErrorEvaluate'] = 0;
        $_POST['tx_t3registration_pi1']['tx_t3registrationtest_date'] = '1.1.2014';
        $html = $this->loadExtension();
        $this->body = $this->getDomRootFromHTML($html);
        $this->checkError('tx_t3registrationtest_date_field','Date is not correct');
        $this->conf['fieldConfiguration.']['tx_t3registrationtest_date.'] = $this->conf['lib.']['dateWithMax.'];
        $this->conf['fieldConfiguration.']['tx_t3registrationtest_date.']['singleErrorEvaluate'] = 0;
        $_POST['tx_t3registration_pi1']['tx_t3registrationtest_date'] = '1.1.2010';
        $html = $this->loadExtension();
        $this->body = $this->getDomRootFromHTML($html);
        $this->assertXpath('//div[@id="tx_t3registrationtest_date_field"]/div[@class="' . $this->errorClass . '"]',0);

        $this->conf['fieldConfiguration.']['tx_t3registrationtest_date.'] = $this->conf['lib.']['dateWithMin.'];
        $this->conf['fieldConfiguration.']['tx_t3registrationtest_date.']['singleErrorEvaluate'] = 0;
        $_POST['tx_t3registration_pi1']['tx_t3registrationtest_date'] = '1.1.2001';
        $html = $this->loadExtension();
        $this->body = $this->getDomRootFromHTML($html);
        $this->checkError('tx_t3registrationtest_date_field','Date is not correct');


        $this->conf['fieldConfiguration.']['tx_t3registrationtest_date.'] = $this->conf['lib.']['dateBetween.'];
        $this->conf['fieldConfiguration.']['tx_t3registrationtest_date.']['singleErrorEvaluate'] = 0;
        $_POST['tx_t3registration_pi1']['tx_t3registrationtest_date'] = '1.1.2010';
        $html = $this->loadExtension();
        $this->body = $this->getDomRootFromHTML($html);
        $this->assertXpath('//div[@id="tx_t3registrationtest_date_field"]/div[@class="' . $this->errorClass . '"]',0);

        $this->conf['fieldConfiguration.']['tx_t3registrationtest_date.'] = $this->conf['lib.']['dateInFuture.'];
        $this->conf['fieldConfiguration.']['tx_t3registrationtest_date.']['singleErrorEvaluate'] = 0;
        $_POST['tx_t3registration_pi1']['tx_t3registrationtest_date'] = '1.1.2011';
        $html = $this->loadExtension();
        $this->body = $this->getDomRootFromHTML($html);
        $this->checkError('tx_t3registrationtest_date_field','Date is not correct');

        $this->conf['fieldConfiguration.']['tx_t3registrationtest_date.'] = $this->conf['lib.']['dateInPast.'];
        $this->conf['fieldConfiguration.']['tx_t3registrationtest_date.']['singleErrorEvaluate'] = 0;
        $_POST['tx_t3registration_pi1']['tx_t3registrationtest_date'] = '1.1.2014';
        $html = $this->loadExtension();
        $this->body = $this->getDomRootFromHTML($html);
        $this->checkError('tx_t3registrationtest_date_field','Date is not correct');
    }



    protected function assertXpath($xpath,$expectedNodeCount = -1, $expectedNodeValue = ''){
        $entries = $this->xpath->query($xpath);

        if($expectedNodeCount>=0){
            $this->assertEquals($expectedNodeCount,$entries->length,'Found ' . $expectedNodeCount .' entries');
        }
        if($expectedNodeValue && $entries->length == 1){
            $this->assertEquals($expectedNodeValue,$entries->item(0)->nodeValue);
        }

    }

    /**
     * Function to test each error into the form
     * @param string $id
     * @param $expectedText
     */
    protected function checkError($id,$expectedText){
        $entries = $this->xpath->query('//div[@id="' . $id . '"]/div[@class="' . $this->errorClass . '"]');
        $this->assertNotEquals(false,$entries);
        $this->assertEquals(1,$entries->length);
        $this->assertEquals($expectedText,$entries->item(0)->nodeValue);
    }

    public function loadExtension() {
        $content = '';
        $GLOBALS['TSFE']->config['config']['disablePrefixComment'] = 1;
        $methodAndClass = explode('->', $this->conf['userFunc']);
        $classObj = t3lib_div::makeInstance($methodAndClass[0]);
        $classObj->cObj = $this->cObj;
        if (is_object($classObj) && method_exists($classObj, $methodAndClass[1])) {
            $classObj->cObj = $this->cObj;
            $content = call_user_func_array(array($classObj, $methodAndClass[1]
                                            ), array(
                                                    $content, $this->conf
                                               ));
        }
        return $content;
    }

    public function initializeCobj($data = array()) {
        $this->cObj = new tslib_cObj();
        $this->cObj->start($data);
    }

    /**
     * This return the typoscript for t3registration
     * @param array $additionalTyposcriptSetup list of ts string with setup
     * @param array $additionalTyposcriptConstants list of ts string with constants
     * @return array typoscript generated referenced to tx_t3registration plugin
     */
    protected function generateTyposcriptSetup($additionalTyposcriptSetup = array(), $additionalTyposcriptConstants = array()) {
        $this->tstemplate = new t3lib_TStemplate();
        $this->tstemplate->setup = '';
        $this->tstemplate->constants[] = $this->readFromTSFile('constants');
        $this->tstemplate->constants[] = $this->readFromTSFile('constantsFixed');
        $this->tstemplate->config[] = $this->readFromTSFile('setup');
        $this->tstemplate->config[] = $this->readFromTSFile('fixed');
        $this->tstemplate->editorcfg[] = '';
        foreach ($additionalTyposcriptSetup as $additionalSetup) {
            $this->tstemplate->config[] = $additionalSetup;
        }
        foreach ($additionalTyposcriptConstants as $additionalConstants) {
            $this->tstemplate->constants[] = $additionalConstants;
        }
        $this->tstemplate->generateConfig();
        return $this->tstemplate->setup['plugin.']['tx_t3registration_pi1.'];
    }

    /**
     * Return the typoscript from file
     * @param string $type typ3 of standard typoscript to read
     * @return string typoscript string
     */
    protected function readFromTSFile($type = 'setup') {
        $setup = '';
        switch ($type) {
            case 'setup':
                $setup = file_get_contents(t3lib_extMgm::extPath('t3registration', 'static/t3registration_settings/setup.txt'));
                break;
            case 'fixed':
                $setup = file_get_contents(t3lib_extMgm::extPath('t3registration', 'ext_typoscript_setup.txt'));
                break;
            case 'constants':
                $setup = file_get_contents(t3lib_extMgm::extPath('t3registration', 'static/t3registration_settings/constants.txt'));
                break;
            case 'constantsFixed':
                $setup = file_get_contents(t3lib_extMgm::extPath('t3registration', 'ext_typoscript_constants.txt'));
                break;
        }
        return $setup;
    }

    /**
     * This function return the t3registration tag
     * @param string $step step in the eid
     * @param string $test optional indicates what subtest should be executed
     * @return DOMNode body node
     */
    protected function getDomRootFromHTML($html){
        $html = '<html><body>' . $html . '</body></html>';
        $this->doc = new DOMDocument;
        $this->body = new DOMNode;
        $this->doc->loadHTML($html);
        $this->xpath = new DOMXPath($this->doc);
        return $this->doc->getElementsByTagName('body')->item(0);
    }

}
