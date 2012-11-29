<?php
/**
 * Created by JetBrains PhpStorm.
 * User: federico
 * Date: 26/11/12
 * Time: 12:38
 * To change this template use File | Settings | File Templates.
 */




class PersistenceTest extends Tx_Phpunit_Database_TestCase {

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
     * @test
     */
    public function insertUserShouldSendEmail() {
        $setup[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic.ts'));
        $constant[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic_const.ts'));
//        $mailStub = $this->getMock('t3lib_mail_Message');
//        $mailStub->expects($this->once())->method('send');
        $setup[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/piVarsFixture.php'));
        $this->conf = $this->generateTyposcriptSetup($setup,$constant);
        require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/piVarsFixture.php'));
        $userCorrectForDatabaseInsertion = array_merge($userCorrectForDatabaseInsertion,$piVarsBaseForInsertingUser);
        $_POST['tx_t3registration_pi1'] = $userCorrectForDatabaseInsertion;
        $html = $this->loadExtension();
        $this->assertTrue($this->fixture->existsExactlyOneRecord('fe_users','tx_phpunit_is_dummy_record=1'));
        $user = $this->findUserByEmail($userCorrectForDatabaseInsertion['email'],false);
        $this->assertGreaterThan(0,strlen($user['user_auth_code']));
        $this->assertEquals(1,$user['disable']);
        /*debug($html);
        exit;*/
    }

    /**
     * @test
     */
    public function confirmedUserRequestShouldUpdateUserAndRemoveAuthcode(){
        require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/piVarsFixture.php'));
        $_POST['tx_t3registration_pi1'] = array();
        $user = array_merge($userCorrectForDatabaseInsertion,$userCorrectForDatabaseUserConfirmation);
        unset($user['passwordTwice']);
        $this->fixture->createRecord('fe_users',$user);
        $_POST['tx_t3registration_pi1'] = array('action' => 'userAuth','authcode' => $user['user_auth_code']);
        $html = $this->loadExtension();
        $user = $this->findUserByEmail($userCorrectForDatabaseInsertion['email'],false);
        $this->assertEquals(0,strlen($user['user_auth_code']));
        $this->assertEquals(0,$user['disable']);
    }



    /**
     * @test
     */
    public function confirmedUserRequestShouldUpdateUserWithPreUsergroupAndRemoveAuthcode(){
        $setup[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic.ts'));
        $constant[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic_const.ts'));
//        $mailStub = $this->getMock('t3lib_mail_Message');
//        $mailStub->expects($this->once())->method('send');
        $setup[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/piVarsFixture.php'));
        $this->conf = $this->generateTyposcriptSetup($setup,$constant);
        $this->conf['preUsergroup'] = '2,3';
        require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/piVarsFixture.php'));
        $userCorrectForDatabaseInsertion = array_merge($userCorrectForDatabaseInsertion,$piVarsBaseForInsertingUser);
        $_POST['tx_t3registration_pi1'] = $userCorrectForDatabaseInsertion;
        $html = $this->loadExtension();
        $this->assertTrue($this->fixture->existsExactlyOneRecord('fe_users','tx_phpunit_is_dummy_record=1'));
        $user = $this->findUserByEmail($userCorrectForDatabaseInsertion['email'],false);
        $this->assertGreaterThan(0,strlen($user['user_auth_code']));
        $this->assertEquals(1,$user['disable']);
        $this->assertEquals('2,3',$user['usergroup']);
    }



    /**
     * @test
     */
    public function confirmedUserRequestWithChangeGroupShouldUpdateUserAndGroupAndRemoveAuthcode(){
        require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/piVarsFixture.php'));
        $_POST['tx_t3registration_pi1'] = array();
        $user = array_merge($userCorrectForDatabaseInsertion,$userCorrectForDatabaseUserConfirmation,$userGroupsBeforeConfirmation);
        unset($user['passwordTwice']);
        $this->fixture->createRecord('fe_users',$user);
        $this->conf['preUsergroup'] = '2,3';
        $this->conf['postUsergroup'] = '3,4';
        //$this->conf['@test'] = '1';
        $_POST['tx_t3registration_pi1'] = array('action' => 'userAuth','authcode' => $user['user_auth_code']);
        $html = $this->loadExtension();
        $user = $this->findUserByEmail($userCorrectForDatabaseInsertion['email'],false);
        $this->assertEquals(0,strlen($user['user_auth_code']));
        $this->assertEquals(0,$user['disable']);
        $this->assertEquals('3,4',$user['usergroup']);
    }


    /*public function deleteUserRequestWithDeletedFlagSetShouldUpdateUserAndNotDeleteIt(){
        require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/piVarsFixture.php'));
        $_POST['tx_t3registration_pi1'] = array();
        $user = array_merge($userCorrectForDatabaseInsertion,$userCorrectForDatabaseUserConfirmation);
        unset($user['passwordTwice']);
        $this->fixture->createRecord('fe_users',$user);
        $_POST['tx_t3registration_pi1'] = array('action' => 'userDeleteConfirmation','authcode' => $user['user_auth_code']);
        $html = $this->loadExtension();
        $user = $this->findUserByEmail($userCorrectForDatabaseInsertion['email'],false);
        $this->assertEquals(0,strlen($user['user_auth_code']));
        $this->assertEquals(0,$user['disable']);
        $this->assertEquals(1,$user['deleted']);
    }*/

    protected function findUserByEmail($email,$enableFields = true){
        $where = 'email = ' . $GLOBALS['TYPO3_DB']->fullQuoteStr($email,'fe_users') . (($enableFields)?$this->cObj->enableFields('fe_users'):'');
        $row = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow('*','fe_users',$where);
        return $row;
    }

    protected function findUserByAuthCode($authCode,$enableFields = true){
        $where = 'user_auth_code = ' . $GLOBALS['TYPO3_DB']->fullQuoteStr($authCode,'fe_users') . (($enableFields)?$this->cObj->enableFields('fe_users'):' AND fe_users.deleted=0');
        $row = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow('*','fe_users',$where);
        return $row;
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
