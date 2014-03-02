<?php

namespace gps\gam\model\dao;

use gps\gam\model\data_object\User_DO;

require_once (dirname(__FILE__) . '/Abstract_Data_Access_Object.php');

/* 
 * User Data Access Object
 * 
 * Contains functions uses to interact with database on behalf of User Data Object
 * 
 */

class User_DAO extends Abstract_Data_Access_Object{
    
    const TABLE_SUFFIX = "users"; //table name without the prefix
    static $cache = array(); //store previously loaded data objects
    
    public static function load(User_DO $user) {
        
        //check to see if object was cached
        $cached = self::$cache[$user->get_id()];
        if (isset( $cached ) && $cached->is_hydrated){
            return $user = $cached;
        }
        
        global $wpdb;
        
        $sql = "SELECT * FROM " 
                . self::get_table_name() 
                . " WHERE id=" . $user->get_id();
        
        $results = $wpdb->get_row( $sql );
        
        $user->set_user_login( $results->user_login );
        $user->set_user_pass( $results->user_pass );
        $user->set_user_nicename( $results->user_nicename );
        $user->set_user_email( $results->user_email );
        $user->set_user_url( $results->user_url );
        $user->set_user_registered( $results->user_registered );
        $user->set_user_activation( $results->user_activation );
        $user->set_user_status( $results->user_status );
        $user->set_display_name( $results->display_name );
        $user->set_spam( $results->spam );
        $user->set_deleted( $results->deleted );
        
        $user->is_hydrated = true;
        
    }
    
    protected static function get_table_name() {
        global $wpdb;
        return $wpdb->prefix . self::TABLE_SUFFIX;
    }

}

