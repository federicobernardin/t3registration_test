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

    public function setUp(){
        $this->configuration = $GLOBALS['T3RegistrationConfiguration'];
        $this->doc = new DOMDocument;
        $this->body = new DOMNode;



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
        $t3registration = new T3RegistrationTest();
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

class T3RegistrationTest{

    public $externalPiVars;

    public $externalConf;

    public $externalFields;

    public function init(){
        $this->init();
        $this->piVars = array_merge($this->piVars,$this->externalPiVars);
        $this->conf = array_merge($this->conf,$this->externalConf);
    }
}