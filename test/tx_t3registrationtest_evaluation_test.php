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
        require_once('../../../localconf.php');
        $this->configuration = unserialize($TYPO3_CONF_VARS['EXT']['extConf']['t3registration_test']);
        print_r($this->configuration);
        $this->pathSite = '/Users/federico/Sites/TYPO3/typo3v6/';
        define('PATH_site', $this->pathSite);
        define('PATH_t3lib', PATH_site.'t3lib/');
        define('TYPO3_mainDir', 'typo3/');		// This is the directory of the backend administration for the sites of this TYPO3 installation.
        define('PATH_typo3', PATH_site.TYPO3_mainDir);
        define('PATH_typo3conf', PATH_site.'typo3conf/');
        define('PATH_tslib', PATH_site.TYPO3_mainDir.'sysext/cms/tslib/');
        require_once(PATH_t3lib . 'class.t3lib_div.php');
        require_once(PATH_t3lib . 'class.t3lib_extmgm.php');
        require_once(PATH_typo3conf . 'ext/t3registration_test/library/class.tx_t3registrationtest_http.php');
        require_once(PATH_tslib . 'class.tslib_eidtools.php');

    }

    public function testEvaluationStandardRules()
    {
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
        $this->checkError('tx_t3registrationtest_date_field','Password is not correct');

        /*
         * Test password error
         */
        $this->checkError('passwordField','Password is not correct');

        //print_r($tbody->getElementsByTagName('div')->item(0)->nodeValue);
        //$this->assertRegExp('/class="errorT3RegistrationClass"/',$http);
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

    protected function callWebPage($step,$test = ''){
        $http = tx_t3registrationtest_http::sendHTTP('http://t3r6/?eID=t3registration_test&enabletest=1&step=evaluation');
        $this->doc = new DOMDocument;

        $this->doc->loadHTML($http);

        $this->xpath = new DOMXPath($this->doc);

        $this->body = $this->doc->getElementsByTagName('body')->item(0);
    }
}