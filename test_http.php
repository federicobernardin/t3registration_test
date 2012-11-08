<?php
/**
 * Created by JetBrains PhpStorm.
 * User: federico
 * Date: 15/10/12
 * Time: 15:07
 * To change this template use File | Settings | File Templates.
 */

require_once('library/class.tx_t3registrationtest_http.php');



        $http = tx_t3registrationtest_http::sendHTTP('http://t3r6/?eID=t3registration_test&enabletest=1&step=evaluation');
//echo($http);
$retVal = preg_match_all('/<div class="tx-t3registration-pi1">(.*)<\/div>/iUs',$http,$pippo);

$doc = new DOMDocument;

$doc->loadHTML($http);

$xpath = new DOMXPath($doc);

$body = $doc->getElementsByTagName('body')->item(0);
$entries = $xpath->query('//div[@id="passwordField"]/div[@class="errorT3RegistrationClass"]',$body);
print_r(count($entries));
//$doc->getElementById('passwordField');
foreach ($entries as $entry) {
    echo "Found {$entry->nodeValue}," ;
}
//if();
//print_r($tbody->getElementsByTagName('div')->item(0)->nodeValue);


// our query is relative to the tbody node
//$query = 'count(row/entry[. = "en"])';

//$entries = $xpath->evaluate($query, $tbody);
//echo "There are $entries english books\n";
//$retVal = preg_match_all('/class="errorT3RegistrationClass"/iUs',$http,$pippo);
//print_r($tbody);
