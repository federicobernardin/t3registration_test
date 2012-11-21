<?php
/**
 * Created by JetBrains PhpStorm.
 * User: federico
 * Date: 15/10/12
 * Time: 16:38
 * To change this template use File | Settings | File Templates.
 */



class tx_t3registrationtest_evaluation_test  extends PHPUnit_Framework_TestCase{

    protected $xpath;

    protected $doc;

    protected $body;

    protected $errorClass = 'errorT3RegistrationClass';

    protected $pathSite;

    protected $configuration;

    /**
     * @var T3RegistrationTest T3registration class
     */
    protected $object;

    public function setUp(){
        $this->configuration = $GLOBALS['T3RegistrationConfiguration'];
        $this->doc = new DOMDocument;
        $this->body = new DOMNode;
        $this->object = new T3RegistrationTest();
    }

    public function testEvaluationStandardRulesFromWeb()
    {

        $this->body = $this->callWebPage('evaluation');

         /*
         * Test password error
         */
        $this->checkError('passwordField','Password is not correct');

        /*
         * Test password error
         */
        $this->checkError('emailField','Email is not correct');

        /*
         * Test password error
         */
        //$this->checkError('tx_t3registrationtest_date_field','Password is not correct');


        //print_r($tbody->getElementsByTagName('div')->item(0)->nodeValue);
        //$this->assertRegExp('/class="errorT3RegistrationClass"/',$http);
    }

    public function testEvaluationDate(){
        $this->checkdate();
        $this->checkdate('America/New_York');
    }

    public function testEvaluationInt(){
        $this->assertTrue($this->object->evaluateTest(12,'int',array()));
        $this->assertTrue($this->object->evaluateTest('300','int',array()));
        $this->assertFalse($this->object->evaluateTest('noInt','int',array()));
    }

    public function testEvaluationString(){
        $this->assertTrue($this->object->evaluateTest('This is a string with strange character: @§è','alpha',array()));
        $this->assertTrue($this->object->evaluateTest('This is a string without starnge character','string',array()));
        $this->assertFalse($this->object->evaluateTest(300,'string',array()));
        $this->assertFalse($this->object->evaluateTest(300,'alpha',array()));
    }

    public function testEvaluationEmail(){
        $this->assertTrue($this->object->evaluateTest('myemail.email@emaildomain.com','email',array()));
        $this->assertTrue($this->object->evaluateTest('myemail.email@domain.emaildomain.com','email',array()));
        $this->assertFalse($this->object->evaluateTest('myemail.email@','email',array()));
        $this->assertFalse($this->object->evaluateTest('myemail.email.emaildomain.com','email',array()));
    }

    public function testEvaluationRegExp(){
        $field['regexp'] = '^[a-zA-Z\s]+$';
        $this->assertGreaterThan(0,$this->object->evaluateTest('test of regular expression','regexp',$field));
        $this->assertEquals(0,$this->object->evaluateTest('test of regular expression with number: 4545454','regexp',$field));
        $this->assertEquals(0,$this->object->evaluateTest('test of regular expression with special chars: %&$§','regexp',$field));
    }


    public function testEvaluationPassword(){
        $field['config']['maxchars'] = 10;
        $field['config']['minchars'] = 3;
        $this->assertTrue($this->object->evaluateTest('1234567890','password',$field));
        $this->assertFalse($this->object->evaluateTest('12','password',$field));
        $this->assertFalse($this->object->evaluateTest('123456789012','password',$field));
    }

    /**
     * This function checks if date requirements are satisfied
     * @param string $timezone
     */
    protected function checkdate($timezone = ''){
        if(strlen($timezone)){
            $field['config']['date']['timezone'] = $timezone;
        }

        //2/1/2012
        $dateAfter = '2.1.2012';

        //2/1/2012
        $dateInFuture = '2.1.2050';

        //31/12/2012
        $dateBefore = '31.12.2011';
        $field['config']['date']['strftime'] = 'd.m.Y';

        //evaluate date
        $field['config']['date']['maxDate'] = '1.1.2012';
        $this->assertFalse($this->object->evaluateTest($dateAfter,'date',$field));
        $this->assertTrue($this->object->evaluateTest($dateBefore,'date',$field));
        unset($field['config']['date']['maxDate']);
        $field['config']['date']['minDate'] = '1.1.2012';
        $this->assertFalse($this->object->evaluateTest($dateBefore,'date',$field));
        $this->assertTrue($this->object->evaluateTest($dateAfter,'date',$field));
        $field['config']['date']['maxDate'] = '10.1.2012';
        $field['config']['date']['minDate'] = '1.12.2011';
        $this->assertTrue($this->object->evaluateTest($dateBefore,'date',$field));
        $this->assertTrue($this->object->evaluateTest($dateAfter,'date',$field));
        $field['config']['date']['maxDate'] = '10.12.2011';
        $field['config']['date']['minDate'] = '1.12.2011';
        $this->assertFalse($this->object->evaluateTest($dateBefore,'date',$field));
        $this->assertFalse($this->object->evaluateTest($dateAfter,'date',$field));
        unset($field['config']['date']['maxDate']);
        unset($field['config']['date']['minDate']);
        $field['config']['date']['dateHasToBeIn'] = 'future';
        $this->assertFalse($this->object->evaluateTest($dateBefore,'date',$field));
        $this->assertTrue($this->object->evaluateTest($dateInFuture,'date',$field));
        $field['config']['date']['dateHasToBeIn'] = 'past';
        $this->assertFalse($this->object->evaluateTest($dateInFuture,'date',$field));
        $this->assertTrue($this->object->evaluateTest($dateBefore,'date',$field));
    }

    /**
     * Function to test each error into the form
     * @param string $id
     * @param $expectedText
     */
    protected function checkError($id,$expectedText){
        $entries = $this->xpath->query('//div[@id="' . $id . '"]/div[@class="' . $this->errorClass . '"]',$this->body);
        $this->assertNotEquals(false,$entries);
        $this->assertEquals(1,$entries->length);
        $this->assertEquals($expectedText,$entries->item(0)->nodeValue);
    }

    /**
     * This function execute calling to a specific webpage
     * @param string $step step in the eid
     * @param string $test optional indicates what subtest should be executed
     * @return DOMNode body node
     */
    protected function callWebPage($step,$test = ''){
        $http = tx_t3registrationtest_http::sendHTTP($this->configuration['siteName'] . '/?eID=t3registration_test&enabletest=1&step='. $step . '&eval_test=' . $test);

        $this->doc->loadHTML($http);

        $this->xpath = new DOMXPath($this->doc);

        return $this->doc->getElementsByTagName('body')->item(0);
    }
}

class T3RegistrationTest extends tx_t3registration_pi1{

    public $externalPiVars;

    public $externalConf;

    public $externalFields;

    public function init(){
        $this->init();
        $this->piVars = array_merge($this->piVars,$this->externalPiVars);
        $this->conf = array_merge($this->conf,$this->externalConf);
    }

    public function evaluateTest($value, $evaluationRule, $field = array()){
        return $this->evaluateField($value, $evaluationRule, $field);
    }

}