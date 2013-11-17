<?php

namespace gps\gam\models;

/* 
 * Affiliation
 * 
 * This just stores info for one Affiliation object
 * 
 * Author: Patrick Jackson, Golden Path Solutions, Inc.
 * Date: 2013-11-16
 * Copyright: Golden Path Solutions, All Rights Reserved
 * 
 */

class Affiliation {
    
    var $id = null;                     //integer - this object's id
    var $group = null;                  //Group object
    var $creator = null;                //Member object
    var $affiliation_collection = null; //Affiliation Collection object that contains this Affiliation
    var $name = null;                   //String - name of this Affiliation
    var $description = null;            //String - description of this Affiliation
    var $priority = 0;                  //tinyint - priority of this affiliation in a list (order)
    var $date_created = null;           //Date string
    
    
    //populate this object if given an id
    function __construct($id = null) {
        
    }
    
}
