<?php

namespace gps\gam\controllers;

use gps\gam\model\data_object\Group_DO;
use gps\gam\model\data_object\Affiliation_Collection_DO;
use gps\gam\model\data_object\User_DO;
use gps\gam\model\dao\Affiliation_Collection_DAO;

require_once( dirname(__FILE__) . '/Abstract_Controller.php' );

require_once( dirname(dirname(__FILE__)) . '/model/data_object/Affiliation_Collection_DO.php' );
require_once( dirname(dirname(__FILE__)) . '/model/data_object/Group_DO.php' );
require_once( dirname(dirname(__FILE__)) . '/model/data_object/User_DO.php' );
require_once( dirname(dirname(__FILE__)) . '/model/dao/Affiliation_Collection_DAO.php' );

/**
 * This is used to handle requests for managing affiliation collections
 */
class Affiliation_Collection_Controller extends Abstract_Controller {
    
    private static $instance; //Singleton instance
    
    public function handle(){

        if (!$_SERVER['REQUEST_METHOD'] == 'POST'){
            die('The Request didn\'t contain the expected POST content of the form.');
        }

        $method = filter_input(INPUT_POST, 'method'); 

        switch($method) {  
            case "add" :  
                self::add_affiliation_collection();  
            break;  
            case "delete" :  
                self::delete_affiliation_collection();  
            break;  
            case "update" :  
                self::update_affiliation_collection();  
            break; 
            case "get" :  
                self::get_affiliation_collection();  
            break;  
        }
    }

    protected static function add_affiliation_collection(){
        
        try {

            $collection = new Affiliation_Collection_DO();
            $collection->set_creator( new User_DO ( filter_input(INPUT_POST, 'creator_id') ) );
            $collection->set_group( new Group_DO( filter_input(INPUT_POST, 'group_id') ) );
            $collection->set_name( filter_input(INPUT_POST, 'name') );
            $collection->set_description( filter_input(INPUT_POST, 'description') );
            
            $inheritable = filter_input(INPUT_POST, 'inheritable');
            $collection->set_inheritable( $inheritable && $inheritable == "on" );
            
            $collection->set_date_created( date( 'Y-m-d H:i:s') );        
            
            if ( !Affiliation_Collection_DAO::save($collection) )
                die("{\"Error\":\"Failed to save the Affiliation Collection.\"}");
            
        } catch (Exception $ex) {
            die("{\"Error\": \"Exception error thrown while trying to save the Affiliation Collection. " . $ex->get_message() . "\"}");
        }
        
        die($collection->to_JSON());

    }
    
    protected static function delete_affiliation_collection(){
        
        try {
            
            if (!$_REQUEST['collection_id'])
                die("{\"Error\":\"Failed to delete the Affiliation Collection. No Collection ID found.\"}");

            $collection = new Affiliation_Collection_DO( filter_input(INPUT_POST, 'collection_id') );
                    
            if ( !Affiliation_Collection_DAO::delete($collection) )
                die("{\"Error\":\"Failed to save the Affiliation Collection.\"}");
            
        } catch (Exception $ex) {
            die("{\"Error\": \"Exception error thrown while trying to save the Affiliation Collection. " . $ex->get_message() . "\"}");
        }
        
        die("{\"Sucess\":\"true\"}");
    }
    
    /**
     * Using Singleton Pattern
     * @return type
     */
    public static function getInstance() {

        if (!isset(self::$instance)) {
            self::$instance = new Affiliation_Collection_Controller();
        }

        return self::$instance;
    }

}
