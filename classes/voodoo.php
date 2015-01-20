<?php

class Voodoo {

    private static $_handlerHolder = null;

    private static $_init = false;

    private static $_isCli = false;

    private static $_isWebPage = false;

    private static $_isAjax = false;

    public static function getHandlerHolder() {

        if(self::$_handlerHolder == null) {
            self::$_handlerHolder = new Voodoo();
        }

        return self::$_handlerHolder;
    }

    public static function run () {

        if(self::$_init == false) {
            self::$_init = true;
        }

        spl_autoload_register(array(__CLASS__, 'splRegister'));
        set_exception_handler(array(__CLASS__,'handleException'));
        set_error_handler(array(__CLASS__,'handleError'));
        self::_initHandlers();
    }

    protected static function _initHandlers() {

        $handlerTypes = explode(',' ,Config::get('weibo', 'type', 'handler'));

        foreach ( $handlerTypes as $type ) {
            /**
             * @var $handlerName Broker
             */
            $handlerName = 'Broker_'.ucfirst(strtolower(trim($type)));

            $handlerName::register(Voodoo::getHandlerHolder());
        }
    }

    public static function splRegister($class) {
        if (class_exists($class, FALSE) || interface_exists($class, FALSE)) {
            return TRUE;
        }

    }



    public static function handleException($exception) {

    }

    public static function handleError() {

    }


    protected static function identifyRequest() {
        if ( PHP_SAPI == 'cli') {
            return (self::$_isCli = true);
        }

        if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return (self::$_isAjax = true);
        }

        return (self::$_isWebPage = true);
    }

    public static function isCli() {
        return self::$_isCli;
    }

    public static function isAjax() {
        return self::$_isAjax;
    }

    public static function isWebPage() {
        return self::$_isWebPage;
    }


} 