<?php
/**
 * Created by JetBrains PhpStorm.
 * User: federico
 * Date: 15/10/12
 * Time: 14:51
 * To change this template use File | Settings | File Templates.
 */
class tx_t3registrationtest_http {

    public static function sendHTTP($url,$post = array(),$get = array()){
        $handle = curl_init();
        if(is_array($post) and count($post)){
            $fields_string = '';
            foreach($post as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
            rtrim($fields_string, '&');
            curl_setopt($handle,CURLOPT_POST, count($post));
            curl_setopt($handle,CURLOPT_POSTFIELDS, $fields_string);
        }
        if(is_array($get) and count($get)){
            $fields_string = '';
            foreach($get as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
            rtrim($fields_string, '&');
            if(strstr($url,'?')){
                $url .= '&' . $fields_string;
            }
            else{
                $url .= '?' . $fields_string;
            }
        }

        curl_setopt($handle,CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1); //do not output directly, use variable

        //

        //echo($url);
        //exit;
//execute post
        $result = curl_exec($handle);

//close connection
        curl_close($handle);
        return $result;

    }

}
