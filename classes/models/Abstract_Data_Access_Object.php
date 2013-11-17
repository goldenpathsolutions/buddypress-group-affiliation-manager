<?php

namespace gps\gam\models;

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
    
    var $table_name = '';
    
    public function get_table_name(){ return $this->table_name; }
    
    public function set_table_name( $table_name = '' ){ 
        $this->table_name = $table_name; 
    }

    
    /**
     * 
     * Given a Data Object's id and table, return the record for that object
     * 
     * @param type $object_id
     * @param type $table_name
     * @return type
     */
    public static function load($object){
        
        global $wpdb;
        
        $sql = "SELECT * FROM " . $object->get_table_name() . " WHERE id=" . $object->get_id();
        
        return $wpdb->get_results($sql);
    }
    
    /**
     * Given a Data Object, stores all of that object's values
     * Returns the object's id
     * 
     * @param type $object
     * @return int
     */
    public static function save($object){
        return 1;
    }
    
}

