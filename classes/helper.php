<?php


class Helper {

    public static function isValidationRequest() {
        return isset ( $_GET['echostr'] );
        //return ( isset($_GET["signature"]) && isset($_GET["timestamp"]) && isset($_GET["nonce"]) );
    }
    public static function checkSignature() {

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $app_secret= Config::get( 'weibo','appsecret' );
        $tmpArr = array( $app_secret, $timestamp, $nonce );
        sort( $tmpArr, SORT_STRING );
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    public static function doValidation() {

        if(self::checkSignature()) {
            echo $_GET['echostr'];
        }
        die();
    }

} 