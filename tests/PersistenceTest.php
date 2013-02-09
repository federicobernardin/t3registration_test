<?php
/***************************************************************
 * Copyright notice
 *
 * (c) 2004-2012 Federico Bernardin <federico@bernardin.it>
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

/**
 * This test class tests database operation with persistence and mail sending
 * system
 *
 * @author  Federico Bernardin <federico@bernardin.it>
 * @package tx_t3registration
 * @subpackage test
 */
class PersistenceTest extends Tx_Phpunit_Database_TestCase {

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
     * User completes registration process without double opt-in
     * @test
     */
    public function UserCompletesRegistrationProcessWithoutConfirmationProcessShouldConfirmUserAndNoEmailIsSent() {
        $setup[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic.ts'));
        $constant[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic_const.ts'));
        $this->conf = $this->generateTyposcriptSetup($setup,$constant);
        require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/piVarsFixture.php'));
        $userCorrectForDatabaseInsertion = array_merge($userCorrectForPiVars,$piVarsBaseForInsertingUser);
        $_POST['tx_t3registration_pi1'] = $userCorrectForDatabaseInsertion;
        $t3RegistrationMock = $this->getMock('tx_t3registration_pi1',array('sendEmail'));
        $t3RegistrationMock->expects(new PHPUnit_Framework_MockObject_Matcher_InvokedCount(0))->method('send');
        $html = $this->loadExtension();
        $this->assertTrue($this->fixture->existsExactlyOneRecord('fe_users','tx_phpunit_is_dummy_record=1'));
        $user = $this->findUserByEmail($userCorrectForDatabaseInsertion['email'],false);
        $this->assertEquals(0,strlen($user['user_auth_code']));
        $this->assertEquals(0,$user['disable']);
    }

    /**
     * User completes registration process without double opt-in but post usergroup
     * @test
     */
    public function UserCompletesRegistrationProcessWithoutConfirmationProcessButPostUsergroupsShouldConfirmUserAndUpdateUsergroupsAndNoEmailIsSent() {
        $setup[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic.ts'));
        $constant[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic_const.ts'));
        $this->conf = $this->generateTyposcriptSetup($setup,$constant);
        $this->conf['postUsergroup'] = '3,4';
        require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/piVarsFixture.php'));
        $userCorrectForDatabaseInsertion = array_merge($userCorrectForPiVars,$piVarsBaseForInsertingUser);
        $_POST['tx_t3registration_pi1'] = $userCorrectForDatabaseInsertion;
        $t3RegistrationMock = $this->getMock('tx_t3registration_pi1',array('sendEmail'));
        $t3RegistrationMock->expects(new PHPUnit_Framework_MockObject_Matcher_InvokedCount(0))->method('send');
        $html = $this->loadExtension();
        $this->assertTrue($this->fixture->existsExactlyOneRecord('fe_users','tx_phpunit_is_dummy_record=1'));
        $user = $this->findUserByEmail($userCorrectForDatabaseInsertion['email'],false);
        $this->assertEquals(0,strlen($user['user_auth_code']));
        $this->assertEquals(0,$user['disable']);
        $this->assertEquals('3,4',$user['usergroup']);
    }





    /**
     * User completes registration process without double opt-in but post usergroup and usergroup are passed via pivars
     * @test
     */
    public function UserCompletesRegistrationProcessWithoutConfirmationProcessWithUsergroupPassedViaPivarsButPostUsergroupsShouldConfirmUserAndUpdateUsergroupsAndNoEmailIsSent() {
        $setup[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic.ts'));
        $constant[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic_const.ts'));
        $this->conf = $this->generateTyposcriptSetup($setup,$constant);
        $this->conf['postUsergroup'] = '3,4';
        require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/piVarsFixture.php'));
        $userCorrectForDatabaseInsertion = array_merge($userCorrectForPiVars,$piVarsBaseForInsertingUser);
        $userCorrectForDatabaseInsertion['usergroup'] = '4,5';
        $_POST['tx_t3registration_pi1'] = $userCorrectForDatabaseInsertion;
        require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/CObjData.php'));
        $this->initializeCobj($tt_contentDataWithUsergroup);
        $t3RegistrationMock = $this->getMock('tx_t3registration_pi1',array('sendEmail'));
        $t3RegistrationMock->expects(new PHPUnit_Framework_MockObject_Matcher_InvokedCount(0))->method('send');
        $html = $this->loadExtension();
        $this->assertTrue($this->fixture->existsExactlyOneRecord('fe_users','tx_phpunit_is_dummy_record=1'));
        $user = $this->findUserByEmail($userCorrectForDatabaseInsertion['email'],false);
        $this->assertEquals(0,strlen($user['user_auth_code']));
        $this->assertEquals(0,$user['disable']);
        $this->assertEquals('4,5,3',$user['usergroup']);
    }





    /**
     * User completes registration process with double opt-in
     * @test
     */
    public function UserCompletesRegistrationProcessWithDoubleOptinShouldCreateUserAndDisableUserAndSendHimAnEmail() {
        $setup[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic.ts'));
        $constant[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic_const.ts'));
        $this->conf = $this->generateTyposcriptSetup($setup,$constant);
        $this->conf['approvalProcess'] = 'doubleOptin';
        $this->conf['preUsergroup'] = '3,4';
        require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/piVarsFixture.php'));
        $userCorrectForDatabaseInsertion = array_merge($userCorrectForPiVars,$piVarsBaseForInsertingUser);
        $_POST['tx_t3registration_pi1'] = $userCorrectForDatabaseInsertion;
        $t3RegistrationMock = $this->getMock('tx_t3registration_pi1',array('sendEmail'));
        $t3RegistrationMock->expects($this->once())->method('sendEmail');
        $html = $this->loadExtension($t3RegistrationMock);
        $this->assertTrue($this->fixture->existsExactlyOneRecord('fe_users','tx_phpunit_is_dummy_record=1'));
        $user = $this->findUserByEmail($userCorrectForDatabaseInsertion['email'],false);
        $this->assertGreaterThan(0,strlen($user['user_auth_code']));
        $this->assertEquals(1,$user['disable']);
        $this->assertEquals('3,4',$user['usergroup']);
    }



    /**
     * User completes registration process with double opt-in and passing usergroup Via PiVars
     * @test
     */
    public function UserCompletesRegistrationProcessWithDoubleOptinAndUsergroupViaPivarsShouldCreateUserAndDisableUserAndSendHimAnEmail() {
        $setup[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic.ts'));
        $constant[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic_const.ts'));
        $this->conf = $this->generateTyposcriptSetup($setup,$constant);
        $this->conf['approvalProcess'] = 'doubleOptin';
        $this->conf['preUsergroup'] = '3,4';
        require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/piVarsFixture.php'));
        $userCorrectForDatabaseInsertion = array_merge($userCorrectForPiVars,$piVarsBaseForInsertingUser);
        $userCorrectForDatabaseInsertion['usergroup'] = '4,5';
        require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/CObjData.php'));
        $this->initializeCobj($tt_contentDataWithUsergroup);
        $_POST['tx_t3registration_pi1'] = $userCorrectForDatabaseInsertion;
        $t3RegistrationMock = $this->getMock('tx_t3registration_pi1',array('sendEmail'));
        $t3RegistrationMock->expects($this->once())->method('sendEmail');
        $html = $this->loadExtension($t3RegistrationMock);
        $this->assertTrue($this->fixture->existsExactlyOneRecord('fe_users','tx_phpunit_is_dummy_record=1'));
        $user = $this->findUserByEmail($userCorrectForDatabaseInsertion['email'],false);
        $this->assertGreaterThan(0,strlen($user['user_auth_code']));
        $this->assertEquals(1,$user['disable']);
        $this->assertEquals('4,5,3',$user['usergroup']);
    }

	/**
	 * User completes registration process with double opt-in and passing only one usergroup Via PiVars
	 * @test
	 */
	public function UserCompletesRegistrationProcessWithDoubleOptinAndOnlyOneUsergroupViaPivarsShouldCreateUserAndDisableUserAndSendHimAnEmail() {
		$setup[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic.ts'));
		$constant[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic_const.ts'));
		$this->conf = $this->generateTyposcriptSetup($setup,$constant);
		$this->conf['approvalProcess'] = 'doubleOptin';
		$this->conf['preUsergroup'] = '3';
		require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/piVarsFixture.php'));
		$userCorrectForDatabaseInsertion = array_merge($userCorrectForPiVars,$piVarsBaseForInsertingUser);
		require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/CObjData.php'));
		$this->initializeCobj($tt_contentDataWithUsergroup);
		$_POST['tx_t3registration_pi1'] = $userCorrectForDatabaseInsertion;
		$t3RegistrationMock = $this->getMock('tx_t3registration_pi1',array('sendEmail'));
		$t3RegistrationMock->expects($this->once())->method('sendEmail');
		$html = $this->loadExtension($t3RegistrationMock);
		$this->assertTrue($this->fixture->existsExactlyOneRecord('fe_users','tx_phpunit_is_dummy_record=1'));
		$user = $this->findUserByEmail($userCorrectForDatabaseInsertion['email'],false);
		$this->assertGreaterThan(0,strlen($user['user_auth_code']));
		$this->assertEquals(1,$user['disable']);
		$this->assertEquals('3',$user['usergroup']);
	}

	/**
	 * User completes registration process with double opt-in and passing empty usergroup Via PiVars
	 * @test
	 */
	public function UserCompletesRegistrationProcessWithDoubleOptinAndEmptyUsergroupViaPivarsShouldCreateUserAndDisableUserAndSendHimAnEmail() {
		$setup[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic.ts'));
		$constant[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic_const.ts'));
		$this->conf = $this->generateTyposcriptSetup($setup,$constant);
		$this->conf['approvalProcess'] = 'doubleOptin';
		$this->conf['preUsergroup'] = '';
		require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/piVarsFixture.php'));
		$userCorrectForDatabaseInsertion = array_merge($userCorrectForPiVars,$piVarsBaseForInsertingUser);
		require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/CObjData.php'));
		$this->initializeCobj($tt_contentDataWithUsergroup);
		$_POST['tx_t3registration_pi1'] = $userCorrectForDatabaseInsertion;
		$t3RegistrationMock = $this->getMock('tx_t3registration_pi1',array('sendEmail'));
		$t3RegistrationMock->expects($this->once())->method('sendEmail');
		$html = $this->loadExtension($t3RegistrationMock);
		$this->assertTrue($this->fixture->existsExactlyOneRecord('fe_users','tx_phpunit_is_dummy_record=1'));
		$user = $this->findUserByEmail($userCorrectForDatabaseInsertion['email'],false);
		$this->assertGreaterThan(0,strlen($user['user_auth_code']));
		$this->assertEquals(1,$user['disable']);
		$this->assertEquals('',$user['usergroup']);
	}

	/**
	 * User completes registration process with double opt-in and passing only one usergroup and some empty usergroup Via PiVars
	 * @test
	 */
	public function UserCompletesRegistrationProcessWithDoubleOptinAndOnlyOneUsergroupWithEmptyValueViaPivarsShouldCreateUserAndDisableUserAndSendHimAnEmail() {
		$setup[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic.ts'));
		$constant[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic_const.ts'));
		$this->conf = $this->generateTyposcriptSetup($setup,$constant);
		$this->conf['approvalProcess'] = 'doubleOptin';
		$this->conf['preUsergroup'] = ',3,,';
		require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/piVarsFixture.php'));
		$userCorrectForDatabaseInsertion = array_merge($userCorrectForPiVars,$piVarsBaseForInsertingUser);
		require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/CObjData.php'));
		$this->initializeCobj($tt_contentDataWithUsergroup);
		$_POST['tx_t3registration_pi1'] = $userCorrectForDatabaseInsertion;
		$t3RegistrationMock = $this->getMock('tx_t3registration_pi1',array('sendEmail'));
		$t3RegistrationMock->expects($this->once())->method('sendEmail');
		$html = $this->loadExtension($t3RegistrationMock);
		$this->assertTrue($this->fixture->existsExactlyOneRecord('fe_users','tx_phpunit_is_dummy_record=1'));
		$user = $this->findUserByEmail($userCorrectForDatabaseInsertion['email'],false);
		$this->assertGreaterThan(0,strlen($user['user_auth_code']));
		$this->assertEquals(1,$user['disable']);
		$this->assertEquals('3',$user['usergroup']);
	}



    /**
     * User completes registration process with double opt-in and pre usergroups
     * @test
     */
    public function UserCompletesRegistrationProcessWithDoubleOptinAndPresUsergroupsShouldCreateUserAndDisableUserAndSendHimAnEmail() {
        $setup[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic.ts'));
        $constant[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic_const.ts'));
        $this->conf = $this->generateTyposcriptSetup($setup,$constant);
        $this->conf['approvalProcess'] = 'doubleOptin';
        require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/piVarsFixture.php'));
        $userCorrectForDatabaseInsertion = array_merge($userCorrectForPiVars,$piVarsBaseForInsertingUser);
        $_POST['tx_t3registration_pi1'] = $userCorrectForDatabaseInsertion;
        $t3RegistrationMock = $this->getMock('tx_t3registration_pi1',array('sendEmail'));
        $t3RegistrationMock->expects($this->once())->method('sendEmail');
        $html = $this->loadExtension($t3RegistrationMock);
        $this->assertTrue($this->fixture->existsExactlyOneRecord('fe_users','tx_phpunit_is_dummy_record=1'));
        $user = $this->findUserByEmail($userCorrectForDatabaseInsertion['email'],false);
        $this->assertGreaterThan(0,strlen($user['user_auth_code']));
        $this->assertEquals(1,$user['disable']);
    }

    /**
     * User received email and clicked into link inside extension should update user record and enable it and send an email to user
     * @test
     */
    public function confirmedUserRequestShouldUpdateUserAndRemoveAuthcode(){
        require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/piVarsFixture.php'));
        $_POST['tx_t3registration_pi1'] = array();
        $user = array_merge($userCorrectForDatabaseInsertion,$userCorrectForDatabaseUserConfirmation);
        unset($user['passwordTwice']);
        $this->conf['approvalProcess'] = 'doubleOptin';
        $user['disable'] = 1;
        $this->fixture->createRecord('fe_users',$user);
        $_POST['tx_t3registration_pi1'] = array('action' => 'userAuth','authcode' => $user['user_auth_code']);
        $t3RegistrationMock = $this->getMock('tx_t3registration_pi1',array('sendEmail'));
        $t3RegistrationMock->expects(new PHPUnit_Framework_MockObject_Matcher_InvokedCount(0))->method('sendEmail');
        $html = $this->loadExtension($t3RegistrationMock);
        $user = $this->findUserByEmail($userCorrectForDatabaseInsertion['email'],false);
        $this->assertEquals(0,strlen($user['user_auth_code']));
        $this->assertEquals(0,$user['disable']);
    }

    /**
     * User received email and clicked into link inside extension should update user record with post usergroups and enable it and send an email to user
     * @test
     */
    public function confirmedUserRequestWithDoubleOptinAndChangeGroupShouldUpdateUserAndGroupAndRemoveAuthcode(){
        require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/piVarsFixture.php'));
        $_POST['tx_t3registration_pi1'] = array();
        $this->conf['approvalProcess'] = 'doubleOptin';
        $user = array_merge($userCorrectForDatabaseInsertion,$userCorrectForDatabaseUserConfirmation,$userGroupsBeforeConfirmation);
        unset($user['passwordTwice']);
        $this->fixture->createRecord('fe_users',$user);
        $this->conf['preUsergroup'] = '2,3';
        $this->conf['postUsergroup'] = '3,4';
        $_POST['tx_t3registration_pi1'] = array('action' => 'userAuth','authcode' => $user['user_auth_code']);
        $t3RegistrationMock = $this->getMock('tx_t3registration_pi1',array('sendEmail'));
        $t3RegistrationMock->expects(new PHPUnit_Framework_MockObject_Matcher_InvokedCount(0))->method('sendEmail');
        $html = $this->loadExtension($t3RegistrationMock);
        $user = $this->findUserByEmail($userCorrectForDatabaseInsertion['email'],false);
        $this->assertEquals(0,strlen($user['user_auth_code']));
        $this->assertEquals(0,$user['disable']);
        $this->assertEquals('3,4',$user['usergroup']);
    }

	/**
	 * User received email and clicked into link inside extension should update user record with post only one usergroup and enable it and send an email to user. This check a bug with empty array for usergroup with only one element.
	 * @test
	 */
	public function confirmedUserRequestWithDoubleOptinAndChangeGroupWithOneGroupShouldUpdateUserAndGroupAndRemoveAuthcode(){
		require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/piVarsFixture.php'));
		$_POST['tx_t3registration_pi1'] = array();
		$this->conf['approvalProcess'] = 'doubleOptin';
		$user = array_merge($userCorrectForDatabaseInsertion,$userCorrectForDatabaseUserConfirmation,$userOneGroupBeforeConfirmation);
		unset($user['passwordTwice']);
		$this->fixture->createRecord('fe_users',$user);
		$this->conf['preUsergroup'] = '2';
		$this->conf['postUsergroup'] = '4';
		$_POST['tx_t3registration_pi1'] = array('action' => 'userAuth','authcode' => $user['user_auth_code']);
		$t3RegistrationMock = $this->getMock('tx_t3registration_pi1',array('sendEmail'));
		$t3RegistrationMock->expects(new PHPUnit_Framework_MockObject_Matcher_InvokedCount(0))->method('sendEmail');
		$html = $this->loadExtension($t3RegistrationMock);
		$user = $this->findUserByEmail($userCorrectForDatabaseInsertion['email'],false);
		$this->assertEquals(0,strlen($user['user_auth_code']));
		$this->assertEquals(0,$user['disable']);
		$this->assertEquals('4',$user['usergroup']);
	}

	/**
	 * User received email and clicked into link inside extension should update user record with post only one usergroup and enable it and send an email to user. This check a bug with empty array for usergroup with only one element.
	 * @test
	 */
	public function confirmedUserRequestWithDoubleOptinAndChangeGroupWithEmptyValueInGroupShouldUpdateUserAndGroupAndRemoveAuthcode(){
		require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/piVarsFixture.php'));
		$_POST['tx_t3registration_pi1'] = array();
		$this->conf['approvalProcess'] = 'doubleOptin';
		$user = array_merge($userCorrectForDatabaseInsertion,$userCorrectForDatabaseUserConfirmation,$userOneGroupBeforeConfirmation);
		unset($user['passwordTwice']);
		$this->fixture->createRecord('fe_users',$user);
		$this->conf['preUsergroup'] = '2';
		$this->conf['postUsergroup'] = '4,,';
		$_POST['tx_t3registration_pi1'] = array('action' => 'userAuth','authcode' => $user['user_auth_code']);
		$t3RegistrationMock = $this->getMock('tx_t3registration_pi1',array('sendEmail'));
		$t3RegistrationMock->expects(new PHPUnit_Framework_MockObject_Matcher_InvokedCount(0))->method('sendEmail');
		$html = $this->loadExtension($t3RegistrationMock);
		$user = $this->findUserByEmail($userCorrectForDatabaseInsertion['email'],false);
		$this->assertEquals(0,strlen($user['user_auth_code']));
		$this->assertEquals(0,$user['disable']);
		$this->assertEquals('4',$user['usergroup']);
	}


    /**************************CONFIRMATION WITH ADMIN APPROVAL***************/


    /**
     * User completes registration process with double opt-in and admin request
     * @test
     */
    public function UserCompletesRegistrationProcessWithDoubleOptinAndAdminApprovalShouldCreateUserAndDisableUserAndSendToHimAndToAdminAnEmail() {
        $setup[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic.ts'));
        $constant[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic_const.ts'));
        $this->conf = $this->generateTyposcriptSetup($setup,$constant);
        $this->conf['approvalProcess'] = 'doubleOptin,adminApproval';
        $this->conf['preUsergroup'] = '3,4';
        require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/piVarsFixture.php'));
        $userCorrectForDatabaseInsertion = array_merge($userCorrectForPiVars,$piVarsBaseForInsertingUser);
        $_POST['tx_t3registration_pi1'] = $userCorrectForDatabaseInsertion;
        $t3RegistrationMock = $this->getMock('tx_t3registration_pi1',array('sendEmail'));
        $t3RegistrationMock->expects(new PHPUnit_Framework_MockObject_Matcher_InvokedCount(2))->method('sendEmail');
        $html = $this->loadExtension($t3RegistrationMock);
        $this->assertTrue($this->fixture->existsExactlyOneRecord('fe_users','tx_phpunit_is_dummy_record=1'));
        $user = $this->findUserByEmail($userCorrectForDatabaseInsertion['email'],false);
        $this->assertGreaterThan(0,strlen($user['user_auth_code']));
        $this->assertGreaterThan(0,strlen($user['admin_auth_code']));
        $this->assertEquals(1,$user['disable']);
        $this->assertEquals('3,4',$user['usergroup']);
    }

    /**
     * User received email and clicked into link inside extension and admin has already authorized should update user record with post usergroups and enable it
     * @test
     */
    public function confirmedUserRequestWithDoubleOptinAndAdminAuthAndChangeGroupButAdminHasNotYetApprovedShouldRemainUserDisabledAndRemoveAuthcode(){
        require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/piVarsFixture.php'));
        $_POST['tx_t3registration_pi1'] = array();
        $this->conf['approvalProcess'] = 'doubleOptin,adminApproval';
        $user = array_merge($userCorrectForDatabaseInsertion,$userCorrectForDatabaseUserConfirmation,$userGroupsBeforeConfirmation);
        $user['admin_auth_code'] = '';
        $user['disable'] = 1;
        $user['admin_auth_code'] = $adminAuthCode;
        unset($user['passwordTwice']);
        $this->fixture->createRecord('fe_users',$user);
        $this->conf['preUsergroup'] = '2,3';
        $this->conf['postUsergroup'] = '3,4';
        $_POST['tx_t3registration_pi1'] = array('action' => 'userAuth','authcode' => $user['user_auth_code']);
        $t3RegistrationMock = $this->getMock('tx_t3registration_pi1',array('sendEmail'));
        $t3RegistrationMock->expects(new PHPUnit_Framework_MockObject_Matcher_InvokedCount(0))->method('sendEmail');
        $html = $this->loadExtension($t3RegistrationMock);
        $user = $this->findUserByEmail($userCorrectForDatabaseInsertion['email'],false);
        $this->assertEquals(0,strlen($user['user_auth_code']));
        $this->assertGreaterThan(0,strlen($user['admin_auth_code']));
        $this->assertEquals(1,$user['disable']);
        $this->assertEquals('2,3',$user['usergroup']);
    }

    /**
     * User received email and clicked into link inside extension and admin has already authorized should update user record with post usergroups and enable it
     * @test
     */
    public function confirmedUserRequestWithDoubleOptinAndAdminAuthAndChangeGroupShouldUpdateUserAndGroupAndRemoveAuthcode(){
        require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/piVarsFixture.php'));
        $_POST['tx_t3registration_pi1'] = array();
        $this->conf['approvalProcess'] = 'doubleOptin,adminApproval';
        $user = array_merge($userCorrectForDatabaseInsertion,$userCorrectForDatabaseUserConfirmation,$userGroupsBeforeConfirmation);
        $user['admin_auth_code'] = '';
        $user['disable'] = 1;
        unset($user['passwordTwice']);
        $this->fixture->createRecord('fe_users',$user);
        $this->conf['preUsergroup'] = '2,3';
        $this->conf['postUsergroup'] = '3,4';
        $_POST['tx_t3registration_pi1'] = array('action' => 'userAuth','authcode' => $user['user_auth_code']);
        $t3RegistrationMock = $this->getMock('tx_t3registration_pi1',array('sendEmail'));
        $t3RegistrationMock->expects(new PHPUnit_Framework_MockObject_Matcher_InvokedCount(0))->method('sendEmail');
        $html = $this->loadExtension($t3RegistrationMock);
        $user = $this->findUserByEmail($userCorrectForDatabaseInsertion['email'],false);
        $this->assertEquals(0,strlen($user['user_auth_code']));
        $this->assertEquals(0,strlen($user['admin_auth_code']));
        $this->assertEquals(0,$user['disable']);
        $this->assertEquals('3,4',$user['usergroup']);
    }



    /**
     * Admin gives his authorization should update user record but user remains disabled
     * @test
     */
    public function AdminConfirmedUserButUserHasNotYetConfirmedWithDoubleOptinAndAdminAuthAndChangeGroupAndShouldUpdateUserAndGroupAndRemoveAdminAuthcode(){
        require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/piVarsFixture.php'));
        $_POST['tx_t3registration_pi1'] = array();
        $this->conf['approvalProcess'] = 'doubleOptin,adminApproval';
        $user = array_merge($userCorrectForDatabaseInsertion,$userCorrectForDatabaseUserConfirmation,$userGroupsBeforeConfirmation);
        $user['admin_auth_code'] = $adminAuthCode;
        unset($user['passwordTwice']);
        $user['disable'] = 1;
        $this->fixture->createRecord('fe_users',$user);
        $this->conf['preUsergroup'] = '2,3';
        $this->conf['postUsergroup'] = '3,4';
        $_POST['tx_t3registration_pi1'] = array('action' => 'adminAuth','authcode' => $user['admin_auth_code']);
        $t3RegistrationMock = $this->getMock('tx_t3registration_pi1',array('sendEmail'));
        $t3RegistrationMock->expects(new PHPUnit_Framework_MockObject_Matcher_InvokedCount(0))->method('sendEmail');
        $html = $this->loadExtension($t3RegistrationMock);
        $user = $this->findUserByEmail($userCorrectForDatabaseInsertion['email'],false);
        $this->assertGreaterThan(0,strlen($user['user_auth_code']));
        $this->assertEquals(0,strlen($user['admin_auth_code']));
        $this->assertEquals(1,$user['disable']);
        $this->assertEquals('2,3',$user['usergroup']);
    }

    /**
 * Admin gives his authorization And user has already confirmed should update user record And Enable user
 * @test
 */
    public function AdminGivesAuthorizationRequestWithDoubleOptinAndAdminAuthAndUserHasAlreadyConfirmedAndChangeGroupShouldUpdateUserAndGroupAndRemoveAuthcode(){
        require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/piVarsFixture.php'));
        $this->conf['approvalProcess'] = 'doubleOptin,adminApproval';
        $user = array_merge($userCorrectForDatabaseInsertion,$userCorrectForDatabaseUserConfirmation,$userGroupsBeforeConfirmation);
        $user['admin_auth_code'] = $adminAuthCode;
        $user['user_auth_code'] = '';
        unset($user['passwordTwice']);
        $user['disable'] = 1;
        $this->fixture->createRecord('fe_users',$user);
        $this->conf['preUsergroup'] = '2,3';
        $this->conf['postUsergroup'] = '3,4';
        $_POST['tx_t3registration_pi1'] = array('action' => 'adminAuth','authcode' => $user['admin_auth_code']);
        $t3RegistrationMock = $this->getMock('tx_t3registration_pi1',array('sendEmail'));
        $t3RegistrationMock->expects(new PHPUnit_Framework_MockObject_Matcher_InvokedCount(0))->method('sendEmail');
        $html = $this->loadExtension($t3RegistrationMock);
        $user = $this->findUserByEmail($userCorrectForDatabaseInsertion['email'],false);
        $this->assertEquals(0,strlen($user['user_auth_code']));
        $this->assertEquals(0,strlen($user['admin_auth_code']));
        $this->assertEquals(0,$user['disable']);
        $this->assertEquals('3,4',$user['usergroup']);
    }

    /**
     * Admin gives his authorization And user has already confirmed should update user record And Enable user and send email to advice user
     * @test
     */
    public function AdminGivesAuthorizationRequestWithDoubleOptinAndAdminAuthAndUserHasAlreadyConfirmedAndChangeGroupAndAdviceEmailToUserConfigurationShouldUpdateUserAndGroupAndRemoveAuthcode(){
        require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/piVarsFixture.php'));
        $this->conf['approvalProcess'] = 'doubleOptin,adminApproval';
        $user = array_merge($userCorrectForDatabaseInsertion,$userCorrectForDatabaseUserConfirmation,$userGroupsBeforeConfirmation);
        $user['admin_auth_code'] = $adminAuthCode;
        $user['user_auth_code'] = '';
        unset($user['passwordTwice']);
        $user['disable'] = 1;
        $this->fixture->createRecord('fe_users',$user);
        $this->conf['preUsergroup'] = '2,3';
        $this->conf['postUsergroup'] = '3,4';
        $this->conf['sendUserEmailAfterAuthorization'] = 1;
        $_POST['tx_t3registration_pi1'] = array('action' => 'adminAuth','authcode' => $user['admin_auth_code']);
        $t3RegistrationMock = $this->getMock('tx_t3registration_pi1',array('sendEmail'));
        $t3RegistrationMock->expects(new PHPUnit_Framework_MockObject_Matcher_InvokedCount(1))->method('sendEmail');
        $html = $this->loadExtension($t3RegistrationMock);
        $user = $this->findUserByEmail($userCorrectForDatabaseInsertion['email'],false);
        $this->assertEquals(0,strlen($user['user_auth_code']));
        $this->assertEquals(0,strlen($user['admin_auth_code']));
        $this->assertEquals(0,$user['disable']);
        $this->assertEquals('3,4',$user['usergroup']);
    }


    /***********************************UPDATE PROFILE*********************/

    /**
     * @test
     */
    public function UserUpdateHisDataShouldUpdateDataIntoDb(){
        $setup[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic.ts'));
        $constant[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic_const.ts'));
        $this->conf = $this->generateTyposcriptSetup($setup,$constant);
        $groupID = $this->fixture->createFrontEndUserGroup(array('title' => 'group1'));
        require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/piVarsFixture.php'));
        $user = $userCorrectForDatabaseInsertion;
        //$user['usergroup'] = $groupID;
        $userID = $this->fixture->createFrontEndUser($groupID,$user);
        $this->fixture->loginFrontEndUser($userID);
        $this->assertTrue($this->fixture->isLoggedIn());
        $_POST['tx_t3registration_pi1'] = $userCorrectForPiVarsUpdate;
        $t3RegistrationMock = $this->getMock('tx_t3registration_pi1',array('sendEmail'));
        $t3RegistrationMock->expects(new PHPUnit_Framework_MockObject_Matcher_InvokedCount(0))->method('sendEmail');
        $html = $this->loadExtension($t3RegistrationMock);
        $user = $this->findUserByEmail($userCorrectForDatabaseInsertion['email'],false);
        $this->assertEquals(0,strlen($user['user_auth_code']));
        $this->assertEquals(0,strlen($user['admin_auth_code']));
        $this->assertEquals($userCorrectForPiVarsUpdate['last_name'],$user['last_name']);
        $this->assertEquals(0,$user['disable']);
        $this->assertEquals($groupID,$user['usergroup']);
    }

    /**
     * @test
     */
    public function UserUpdateHisDataShouldUpdateDataIntoDbAndUpdateUsername(){
        $setup[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic.ts'));
        $constant[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic_const.ts'));
        $this->conf = $this->generateTyposcriptSetup($setup,$constant);
        $this->conf['usernameUpdateWhenChangeUsernameField'] = 1;
        $groupID = $this->fixture->createFrontEndUserGroup(array('title' => 'group1'));
        require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/piVarsFixture.php'));
        $user = $userCorrectForDatabaseInsertion;
        $userID = $this->fixture->createFrontEndUser($groupID,$user);
        $this->fixture->loginFrontEndUser($userID);
        $this->assertTrue($this->fixture->isLoggedIn());
        $_POST['tx_t3registration_pi1'] = $userCorrectForPiVarsUpdate;
        $_POST['tx_t3registration_pi1']['email'] = $userForUpdateEmail['email'];
        $t3RegistrationMock = $this->getMock('tx_t3registration_pi1',array('sendEmail'));
        $t3RegistrationMock->expects(new PHPUnit_Framework_MockObject_Matcher_InvokedCount(0))->method('sendEmail');
        $html = $this->loadExtension($t3RegistrationMock);
        $user = $this->findUserByEmail($userForUpdateEmail['email'],false);
        $this->assertEquals(0,strlen($user['user_auth_code']));
        $this->assertEquals(0,strlen($user['admin_auth_code']));
        $this->assertEquals($userCorrectForPiVarsUpdate['last_name'],$user['last_name']);
        $this->assertEquals($userForUpdateEmail['email'],$user['email']);
        $this->assertEquals($userForUpdateEmail['email'],$user['username']);
        $this->assertEquals(0,$user['disable']);
        $this->assertEquals($groupID,$user['usergroup']);
    }


    /***********************************DELETE USER*********************/

    /**
     * User requires to delete his subscription and extension send him an email
     * @test
     */
    public function UserRequiresToDeleteHisSubscriptionShouldExtensionSendsAndEmailToUser(){
        $setup[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic.ts'));
        $constant[] = file_get_contents(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/test_basic_const.ts'));
        $this->conf = $this->generateTyposcriptSetup($setup,$constant);
        require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/piVarsFixture.php'));
        $user = $userCorrectForDatabaseInsertion;
        unset($user['passwordTwice']);
        $groupID = $this->fixture->createFrontEndUserGroup(array('title' => 'group1'));
        $userID = $this->fixture->createFrontEndUser($groupID,$user);
        $_POST['tx_t3registration_pi1'] = array('action' => 'delete');
        $t3RegistrationMock = $this->getMock('tx_t3registration_pi1',array('sendEmail'));
        $t3RegistrationMock->expects(new PHPUnit_Framework_MockObject_Matcher_InvokedCount(0))->method('sendEmail');
        $html = $this->loadExtension($t3RegistrationMock);
        $_POST['tx_t3registration_pi1'] = array('action' => 'delete');
        $this->fixture->loginFrontEndUser($userID);
        $this->assertTrue($this->fixture->isLoggedIn());
        $t3RegistrationMock = $this->getMock('tx_t3registration_pi1',array('sendEmail'));
        $t3RegistrationMock->expects(new PHPUnit_Framework_MockObject_Matcher_InvokedCount(1))->method('sendEmail');
        $html = $this->loadExtension($t3RegistrationMock);
    }

    /**
     * User received an email to confirm his deletion and clicked on it so extension update his profile with deleted flag
     * @test
     */
    public function UserClickedIntoEmailToConfirmHisUnsubscriptionShouldUpdateUserDeleteFlagToOneFromDb(){
        require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/piVarsFixture.php'));
        $this->conf['approvalProcess'] = 'doubleOptin,adminApproval';
        $user = array_merge($userCorrectForDatabaseInsertion,$userCorrectForDatabaseUserConfirmation,$userGroupsBeforeConfirmation);
        unset($user['passwordTwice']);
        $this->fixture->createRecord('fe_users',$user);
        $_POST['tx_t3registration_pi1'] = array('action' => 'userDeleteConfirmation','authcode' => $user['user_auth_code']);
        $html = $this->loadExtension();
        $user = $this->findUserByEmail($userCorrectForDatabaseInsertion['email'],false);
        $this->assertEquals(0,strlen($user['user_auth_code']));
        $this->assertEquals(1,strlen($user['disable']));
        $this->assertEquals(1,$user['deleted']);
    }

    /**
     * User received an email to confirm his deletion and clicked on it so extension remove completely his data
     * @test
     */
    public function UserClickedIntoEmailToConfirmHisUnsubscriptionAndConfiguratioForCompleteDeleteIsEnabledShouldRemoveUserFromDb(){
        require(t3lib_extMgm::extPath('t3registration_test', 'Tests/Fixtures/piVarsFixture.php'));
        $user = array_merge($userCorrectForDatabaseInsertion,$userCorrectForDatabaseUserConfirmation,$userGroupsBeforeConfirmation);
        unset($user['passwordTwice']);
        $this->fixture->createRecord('fe_users',$user);
        $this->conf['delete.']['deleteRow'] = 1;
        $_POST['tx_t3registration_pi1'] = array('action' => 'userDeleteConfirmation','authcode' => $user['user_auth_code']);
        $html = $this->loadExtension();
        $this->assertFalse($this->fixture->existsRecord('fe_users','email=' . $GLOBALS['TYPO3_DB']->fullQuoteStr($userCorrectForDatabaseInsertion['email'])));
    }


    /**
     * This function search into db for specific email user
     * @param string $email
     * @param bool $enableFields
     * @return array of user
     */
    protected function findUserByEmail($email,$enableFields = true){
        $where = 'email = ' . $GLOBALS['TYPO3_DB']->fullQuoteStr($email,'fe_users') . (($enableFields)?$this->cObj->enableFields('fe_users'):'');
        $row = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow('*','fe_users',$where);
        return $row;
    }

    /**
     * This function search into db for specific auth code user
     * @param string $authCode
     * @param bool $enableFields
     * @return array of user
     */
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

    /**
     * @param null $mockedObject
     * @return mixed|string
     */
    public function loadExtension($mockedObject = null) {
        $content = '';
        $GLOBALS['TSFE']->config['config']['disablePrefixComment'] = 1;
        $methodAndClass = explode('->', $this->conf['userFunc']);
        $classObj = (is_null($mockedObject))?t3lib_div::makeInstance($methodAndClass[0]):$mockedObject;
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

    /**
     * @param array $data
     */
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
