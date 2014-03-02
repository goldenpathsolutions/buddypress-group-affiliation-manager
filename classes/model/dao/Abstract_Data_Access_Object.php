<?php

namespace gps\gam\model\dao;

/* 
 * Data Access Object
 * 
 * This Abstract Class is the parent of all other DAOs.  It contains the basic
 * load and save functions that are used by its decendents.  Because we want to 
 * return a loaded object, it'll have to be overridden in each case.  The parent
 * can the basic sql statement, though.
 * 
 * Author: Patrick Jackson, Golden Path Solutions
 * Date: 2013-11-16
 * 
 */

abstract class Abstract_Data_Access_Object {
    
    const NEW_OBJECT = 0;
    
}

