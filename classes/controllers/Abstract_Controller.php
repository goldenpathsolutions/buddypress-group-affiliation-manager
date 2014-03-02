<?php

namespace gps\gam\controllers;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


abstract class Abstract_Controller {
    
    private static $reg = array();
    
    abstract public function handle();
    
    public static function get_instance()
    {
        $cls = get_called_class();
        !isset(self::$reg[$cls]) && self::$reg[$cls] = new $cls;
        return self::$reg[$cls];
    }
    
}

