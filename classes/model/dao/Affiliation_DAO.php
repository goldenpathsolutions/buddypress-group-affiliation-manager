<?php

namespace gps\gam\model\dao;

use gps\gam\model\data_object\Affiliation_DO;
use gps\gam\model\data_object\Affiliation_Collection_DO;
use gps\gam\model\data_object\User_DO;


require_once (dirname(__FILE__) . '/Abstract_Data_Access_Object.php');
require_once (dirname(dirname(__FILE__)) . '/data_object/User_DO.php');
require_once (dirname(dirname(__FILE__)) . '/data_object/Affiliation_DO.php');
require_once (dirname(dirname(__FILE__)) . '/data_object/Affiliation_Collection_DO.php');


/* 
 * Affiliation Data Access Object
 * 
 * Contains functions used to interact with database on behalf of the Affiliation Data Object
 * Author: Patrick Jackson, Golden Path Solutions
 * 
 */

class Affiliation_DAO extends Abstract_Data_Access_Object{
    
    const TABLE_SUFFIX = "gam_affiliations"; //table name without prefix
    static $cache = array(); //store previously loaded data objects

    
    public static function save(Affiliation_DO $affiliation) {
        
        //make sure record exists.  Use insert() if it doesn't
        if( $affiliation->getId() === NEW_OBJECT ){ return insert($affiliation); }
        
        global $wpdb;
        
        $data = array(
            "id" => $affiliation->get_id(),
            "group_id" => $affiliation->get_group()->get_id(),
            "creator_id" => $affiliation->get_creator()->get_id(),
            "name" => $affiliation->get_name(),
            "description" => $affiliation->get_description(),
            "priority" => $affiliation->get_priority(),
            "date_created" => $affiliation->get_date_created()
        );
        
        $formats = array("%d","%d","%d","%s","%s","%d","%s");
        
        $wpdb->update(self::get_table_name(), $data, $formats );
    }
    
    public static function load(Affiliation_DO $affiliation){
        
        //check to see if object was cached
        $cached = self::$cache[$affiliation->get_id()];
        if (isset( $cached ) && $cached->is_hydrated){
            return $affiliation = $cached;
        }
        
        require_once (dirname(dirname(__FILE__)) . '/data_object/Affiliation_Collection_DO.php');
        
        global $wpdb;
        
        $sql = "SELECT * FROM " 
                . self::get_table_name() 
                . " WHERE id=" . $affiliation->get_id();
        
        $results = $wpdb->get_row( $sql );
        
        $affiliation->set_creator( new User_DO ($results->creator_id) );
        $affiliation->set_affiliation_collection( 
                new Affiliation_Collection_DO ($results->affiliation_collection_id ) );
        $affiliation->set_name( $results->name );
        $affiliation->set_description( $results->description );
        $affiliation->set_priority( $results->priority );
        $affiliation->set_date_created( $results->date_created );
        
        $affiliation->is_hydrated = true;
        
        self::$cache[$affiliation->get_id()] = $affiliation;
        
    }
    
    /**
     * Pulls list of this collection's affiliations from database
     * 
     * @global type $wpdb
     * @param \gps\gam\model\dao\Affiliation_Collection_DO $collection
     * @return \gps\gam\model\data_object\Affiliation_DO
     */
    public static function get_by_collection( Affiliation_Collection_DO $collection ){
        
        global $wpdb;
        $affiliations = array();
        
        $sql = "SELECT id FROM " . self::get_table_name() . " WHERE collection_id="
                . $collection->get_id();
        
        $results = $wpdb->get_results($sql);
        
        foreach ( $results as $row ){
           $affiliations[$row->id] = new Affiliation_DO( $row->id ); 
        }
        
        return $affiliations;
    }
    
    public static function get_by_affiliation_collection (Affiliation_Collection_DO $collection){
        
        global $wpdb;
        $affiliations = array();
        
        $sql = "SELECT id FROM " . self::get_table_name() . " WHERE collection_id=" 
                . $collection->get_id();
                
        $results = $wpdb->get_results($sql);
                
        foreach( $results as $row ){
            $affiliations[$row->id] = new Affiliation_DO($row->id);
        }
        
        return $affiliations;
    }
    
    protected static function insert(Affiliation_DO $affiliation) {
        
        global $wpdb;
                        
        $data = array(
            "group_id" => $affiliation->getGroup()->group_id,
            "creator_id" => $affiliation->getCreator()->user_id,
            "name" => $affiliation->getName(),
            "description" => $affiliation->getDescription(),
            "priority" => $affiliation->getPriority(),
            "date_created" => date('y-m-d')
        );
        
        $formats = array("%d","%d","%s","%s","%d","%s");
        
        $wpdb->insert(self::get_table_name(), $data, $formats );
        
        $affiliation->setId( $wpdb->insert_id );
    }
    
    protected static function get_table_name(){ 
        global $wpdb;
        return $wpdb->prefix . self::TABLE_SUFFIX;
    }
    
    protected static function get_cached( Affiliation_DO $affiliation){
        if ($affiliation->get_id() != parent::NEW_OBJECT 
                && self::$cache[$affiliation->get_id()]){
            $cached = self::$cache[$affiliation->get_id()];
            if ($cached->is_hydrated){
                return $affiliation = $cached;
            }
        }
        
        return null;
    }

}