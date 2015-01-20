<?php

interface Broker {

    public static function register($regHandler);

    public static function process();

}