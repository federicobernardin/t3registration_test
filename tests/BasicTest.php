<?php
/**
 * Created by JetBrains PhpStorm.
 * User: federico
 * Date: 26/11/12
 * Time: 12:38
 * To change this template use File | Settings | File Templates.
 */



class BasicTest extends tx_phpunit_testcase {

    /**
     * @var Tx_Phpunit_Framework
     */
    protected $fixture;

    //@var t3lib_TSparser
    protected $parser;

    protected $tstemplate;

    /**
     * @var tslib_cObj
     */
    protected $cObj;

    protected $xpath;

    protected $doc;

    protected $body;

    protected $errorClass = 'errorT3RegistrationClass';

    /**
     * @var array configuration array
     */
    protected $conf;

    public function setUp() {
        $this->fixture = new Tx_Phpunit_Framework('fe_users');
        $this->fixture->createFakeFrontEnd();
        $this->conf = $this->generateTyposcriptSetup();
        //variable should be included at each cycle
        require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/CObjData.php'));
        $this->initializeCobj($tt_contentData);
        require_once(t3lib_extMgm::extPath('t3registration', 'pi1/class.tx_t3registration_pi1.php'));
    }

    public function tearDown(){
        unset($this->fixture);
        unset($this->conf);
        unset($this->cObj);
        unset($this->doc);
        unset($this->body);
        unset($this->xpath);
    }

    /**
     * @test
     */
    public function loadConfigurationShouldBeCallableT3Registration() {
        /*echo(var_export($this->loadExtension(),true));
        exit;*/
        $this->assertEquals('typo3conf/ext/t3registration/pi1/class.tx_t3registration_pi1.php', $this->conf['includeLibs'], 'IncludeLibs not fopund on configuration array');
        $this->assertEquals('tx_t3registration_pi1->main', $this->conf['userFunc'],'userFunc wrong in configuration array');
        $this->assertTrue(file_exists(PATH_site . $this->conf['includeLibs']), 't3registration class not found');
        $methodAndClass = explode('->', $this->conf['userFunc']);
        $this->assertTrue(method_exists($methodAndClass[0], $methodAndClass[1]), 'Method not found');
    }

    /**
     * @test
     */
    public function CallExtensionWithoutUsernameFieldShouldItShowsError() {
        $html = $this->loadExtension();
        $this->body = $this->getDomRootFromHTML($html);
        $expectedText = 'Username not properly configured';
        $entries = $this->xpath->query('//div[@class="message-header"]');
        $this->assertNotEquals(false,$entries,'XPath correctly found');
        $this->assertEquals(1,$entries->length,'Found only 1 entry');
        $this->assertEquals($expectedText,$entries->item(0)->nodeValue,'Value node is as expected');
    }



    /**
     * @test
     */
    public function CallExtensionCorretlyWithDefaultBehaviorShouldReturnBasicForm() {
        $setup[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic.ts'));
        $this->conf = $this->generateTyposcriptSetup($setup);
        $html = $this->loadExtension();
        $this->body = $this->getDomRootFromHTML($html);
        $entries = $this->xpath->query('//form');
        $this->assertNotEquals(false,$entries,'XPath correctly found');
        $this->assertEquals(1,$entries->length,'Found only 1 entry');
        //$this->assertEquals($expectedText,$entries->item(0)->nodeValue,'Value node is as expected');
    }



    /**
     * @test
     */
    public function ExecutesASubmitWithEmptyFieldsShouldBeRaiseAnError() {
        $setup[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic.ts'));
        $constant[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic_const.ts'));
        $this->conf = $this->generateTyposcriptSetup($setup,$constant);
        $_POST['tx_t3registration_pi1']['submitted'] = 1;
        $html = $this->loadExtension();
        $this->body = $this->getDomRootFromHTML($html);
        //$expectedText = 'Username not properly configured';
        $this->checkError('passwordField','Password is not correct');
        $this->checkError('emailField','Email is not correct');
        //$this->assertEquals($expectedText,$entries->item(0)->nodeValue,'Value node is as expected');
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
