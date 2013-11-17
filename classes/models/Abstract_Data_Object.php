<?php

/* 
 * Abstract Data Object
 * 
 * This holds attributes common to all Data Objects
 * 
 * Author: Patrick Jackson, Golden Path Solutions
 * Date: 2013-11-16
 */

abstract class Abstract_Data_Object {
    
    var $id = 0;
    
    
    function __construct($object_id = null){
        if ($object_id == null){
            return null;
        }
    }
}


?>