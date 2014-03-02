<?php

namespace gps\gam\model\dao;

use \gps\gam\model\dao\Abstract_Data_Access_Object;
use \gps\gam\model\data_object\Group_DO;
use \gps\gam\model\data_object\User_DO;

require_once (dirname(__FILE__) . '/Abstract_Data_Access_Object.php');

/* 
 * Group Data Access Object
 * 
 * Contains functions used to interact with database on behalf of Group Data Object
 * 
 */

class Group_DAO extends Abstract_Data_Access_Object{
    
    const TABLE_SUFFIX = "bp_groups"; //table name without the prefix
    static $cache = array(); //store previously loaded data objects
    
    public static function load(Group_DO $group) {
        
        //check to see if object was cached
        $cached = self::$cache[$group->get_id()];
        if (isset( $cached ) && $cached->is_hydrated){
            return $group = $cached;
        }
                
        require_once (dirname(dirname(__FILE__)) . '/data_object/User_DO.php');
        require_once (dirname(dirname(__FILE__)) . '/data_object/Group_DO.php');
                      
        global $wpdb;
        
        $sql = "SELECT * FROM " 
                . Group_DAO::get_table_name() 
                . " WHERE id=" . $group->get_id();
                
        $results = $wpdb->get_row( $sql );
        
        $group->set_creator( new User_DO( $results->creator_id ) );
        $group->set_name( $results->name );
        $group->set_slug( $results->slug );
        $group->set_description( $results->description );
        $group->set_status( $results->status );
        $group->set_enable_forum( $results->enable_forum );
        $group->set_date_created( $results->date_created );
        if( isset($results->parent_id) ){
            $group->set_parent( new Group_DO( $results->parent_id ) );
        }
        
        $group->is_hydrated = true;
        
        self::$cache[$group->get_id()] = $group; //cache this data object
        
    }
    
    protected static function get_table_name() {
        global $wpdb;
        return $wpdb->prefix . self::TABLE_SUFFIX;
    }

    
    

}