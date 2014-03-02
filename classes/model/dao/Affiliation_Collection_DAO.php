<?php
namespace gps\gam\model\dao;

use \gps\gam\model\data_object\Affiliation_Collection_DO;
use \gps\gam\model\data_object\User_DO;
use \gps\gam\model\data_object\Group_DO;

require_once (dirname(__FILE__) . '/Abstract_Data_Access_Object.php');
require_once (dirname(dirname(__FILE__)) . '/data_object/Affiliation_Collection_DO.php');

/* 
 * Affiliation Collection Data Access Object
 * 
 * Contains functions used to interact with database on behalf of the Affiliation Collection Data Object
 * Author: Patrick Jackson, Golden Path Solutions
 */

class Affiliation_Collection_DAO extends Abstract_Data_Access_Object{
    
    const TABLE_SUFFIX = "gam_affiliation_collections"; //table name without the prefix
    static $cache = array(); //store previously loaded data objects

    public static function save(Affiliation_Collection_DO $affiliation_collection) {
        
        //make sure record exists.  Use insert() if it doesn't
        if( $affiliation_collection->get_id() === parent::NEW_OBJECT ){ return self::insert($affiliation_collection); }
        
        global $wpdb;
        
        $data = array(
            "creator_id"    => $affiliation_collection->get_creator()->get_id(),
            "group_id"      => $affiliation_collection->get_group()->get_id(),
            "name"          => $affiliation_collection->get_name(),
            "description"   => $affiliation_collection->get_description(),
            "is_inheritable"=> $affiliation_collection->is_inheritable(),
            "date_created"  => $affiliation_collection->get_date_created()
        );
        
        $formats = array("%d","%d","%s","%s","%d","%s");
        
        $wpdb->update(self::get_table_name(), $data, $formats );
    }
    
    public static function load(Affiliation_Collection_DO $affiliation_collection){

        //check to see if object was cached
        $cached = self::get_cached( $affiliation_collection);
        if ($cached){ return $cached; }
       
        
        require_once (dirname(dirname(__FILE__)) . '/data_object/User_DO.php');
        require_once (dirname(dirname(__FILE__)) . '/data_object/Group_DO.php');
        
        global $wpdb;
        
        $sql = "SELECT * FROM " 
                . self::get_table_name() 
                . " WHERE id=" . $affiliation_collection->get_id();
        
        $results = $wpdb->get_row( $sql );
        
        $affiliation_collection->set_creator( new User_DO( $results->creator_id ) );
        $affiliation_collection->set_group( new Group_DO ( $results->group_id ) );
        $affiliation_collection->set_name( $results->name );
        $affiliation_collection->set_description( $results->description );
        $affiliation_collection->set_inheritable( $results->is_inheritable );
        $affiliation_collection->set_date_created( $results->date_created );
        
        $affiliation_collection->is_hydrated = true;
        
        self::$cache[$affiliation_collection->get_id()] = $affiliation_collection;
    }
    
    /**
     * Gets list of Affiliation Collections for given Group from the Database
     * 
     * @global type $wpdb
     * @param \gps\gam\model\data_object\Group_DO $group
     * @return \gps\gam\model\data_object\Affiliation_Collection_DO
     */
    public static function get_by_group(Group_DO $group){
        
        global $wpdb;
        $collections = array();
        
        $sql = "SELECT id FROM " . self::get_table_name() . " WHERE group_id=" 
                . $group->get_id();
        
        $results = $wpdb->get_results($sql);
        
        foreach( $results as $row ){
            $collections[$row->id] = new Affiliation_Collection_DO($row->id);
        }
        
        return $collections;
    }
    
    protected static function insert(Affiliation_Collection_DO $affiliation_collection) {
        
        global $wpdb, $wp_query;
                        
        $data = array(
            "creator_id"    => $affiliation_collection->get_creator()->get_id(),
            "group_id"      => $affiliation_collection->get_group()->get_id(),
            "name"          => $affiliation_collection->get_name(),
            "description"   => $affiliation_collection->get_description(),
            "is_inheritable"=> $affiliation_collection->is_inheritable(),
            "date_created"  => $affiliation_collection->get_date_created()
        );
        
        $formats = array("%d","%d","%s","%s","%s","%s");
        
        $wpdb->show_errors();
        $result = $wpdb->insert(self::get_table_name(), $data, $formats );
                        
        if ( $result ){
            $affiliation_collection->set_id( $wpdb->insert_id );
            return true;
        } else {
            return false;
        }
    }
    
    protected static function get_table_name() { 
        global $wpdb;
        return $wpdb->prefix . self::TABLE_SUFFIX; 
    }
    
    protected static function get_cached( Affiliation_Collection_DO $affiliation_collection){
        if ($affiliation_collection->get_id() != parent::NEW_OBJECT 
                && self::$cache[$affiliation_collection->get_id()]){
            $cached = self::$cache[$affiliation_collection->get_id()];
            if ($cached->is_hydrated){
                return $affiliation_collection = $cached;
            }
        }
        
        return null;
    }

}