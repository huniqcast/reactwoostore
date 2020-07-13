<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Huniqcast\WPGraphQL\Traits;

/**
 * Description of Singleton
 *
 * @author User
 */
trait Singleton {

    protected static $_instance = null;

    protected function __construct() {
        
    }

    /**
     * 
     * @return \Ottaw\Main
     */
    public static function getInstance() {
        if (self::$_instance == null) {
            self::$_instance = new Self();
        }
        return self::$_instance;
    }

    protected function __clone() {
        
    }

    protected function __sleep() {
        
    }

    protected function __wakeup() {
        
    }

}
