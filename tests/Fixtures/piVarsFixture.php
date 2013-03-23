<?php
/**
 * Created by JetBrains PhpStorm.
 * User: federico
 * Date: 27/11/12
 * Time: 20:34
 * To change this template use File | Settings | File Templates.
 */

$piVarsBaseForInsertingUser = array(
    'passwordTwice' => 'abcdefg',
    'sendConfirmation' => 1,
    'confirmPreview' => 1,
);

$userGroupsBeforeConfirmation = array(
    'usergroup' => '2,3'
);

$userGroupsAfterConfirmation = array(
    'usergroup' => '4,5'
);


$userOneGroupBeforeConfirmation = array(
	'usergroup' => '2'
);

$userOneGroupAfterConfirmation = array(
	'usergroup' => '4'
);


/**
 * This part test group defined into the form
 */
$userFromPiVars = array(
	'usergroup' => '5'
);


$userCorrectForPiVars = array(
    'first_name' => 'TestName',
    'last_name' => 'TestSurname',
    'email' => 'testunit@bernardin.it',
    'password' => 'abcdefg',
    'tx_t3registrationtest_check' =>  1,
    'tx_t3registrationtest_date' =>  '10.9.2011',
    'tx_phpunit_is_dummy_record' =>  1,
);


$userCorrectForDatabaseInsertion = array(
    'first_name' => 'TestName',
    'last_name' => 'TestSurname',
    'email' => 'testunit@bernardin.it',
    'username' => 'testunit@bernardin.it',
    'password' => 'abcdefg',
    'tx_t3registrationtest_check' =>  1,
    'tx_t3registrationtest_date' =>  1260576000,
    'tx_phpunit_is_dummy_record' =>  1,
);

$userCorrectForDatabaseUserConfirmation = array(
    'email' => 'testunit@bernardin.it',
    'user_auth_code' =>  'aaaaaaaaaaaaaaaaaaaaa',
);




$adminAuthCode = 'bbbbbbbbbbbbbbbbbbbbbb';

$userForUpdate = $userCorrectForDatabaseInsertion;
$userForUpdate['last_name'] = 'TestSurnameChanged';
$userForUpdateEmail['email'] = 'testunitchanged@bernardin.it';

$userCorrectForPiVarsUpdate = array_merge($userCorrectForPiVars,array('last_name' => $userForUpdate['last_name']),$piVarsBaseForInsertingUser);
