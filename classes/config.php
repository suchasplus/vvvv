<?php

class Config {

    protected static $_holder = array();

    public static function get($filename, $key = '', $category = '') {
        if ( !is_string($filename) || ($filename = trim(strtolower($filename))) == ''  || strpos($filename, '..') !== FALSE ) {
            throw new InvalidArgumentException;
        }
        $filename_full = VROOT . 'configs'. DS . $filename . '.ini';

        if ( !isset (self::$_holder[$filename]) ) {
            self::$_holder[$filename] = parse_ini_file($filename_full, true);
        }
        //var_dump(self::$_holder[$filename]);

        return ( $category != '' ) ?
            (isset(self::$_holder[$filename][$category][$key]) ? self::$_holder[$filename][$category][$key] : null)
            :
            (isset(self::$_holder[$filename][$key]) ? self::$_holder[$filename][$key] : null) ;

    }

    public static function __callStatic($name, $arguments) {
        if ( strlen($name) > 3 && $name[0] == 'g' && $name[1] == 'e' && $name[2] == 't' ) {
            $filename = substr($name, 3);
        } else {
            throw new BadMethodCallException;
        }

        switch (count($arguments)) {
            case 0:
                return self::get($filename);
            case 1:
                return self::get($filename, $arguments[0]);
            default:
                return self::get($filename, $arguments[0], $arguments[1]);
        }


    }

} 