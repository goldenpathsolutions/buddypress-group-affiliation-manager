<?php
namespace gps\gam\installer;

use gps\gam\Group_Affiliation_Manager;

/* 
 * These functions are used when this plugin is activated
 */

class Installer {
    
    
    
    public function __construct() {
        //$this->validate_requirements();
        $this->set_db_version(); 
        $this->create_tables();
        
    }
    
    
    
    /*private function validate_requirements() {

        global $bp;

        // Make sure required plugins are installed and active
        if ( !(function_exists('buddypress') || is_a($bp, 'BuddyPress') ) ){
            _e('BuddyPress must be installed and active for this plugin');
            exit;
        } else if ( ! bp_is_active( 'groups' )){
            _e('The Groups Plugin must be installed and active for this plugin');
            exit;
        }
    }*/
    
    
    
    private function set_db_version(){
        add_option( "gam_db_version", Group_Affiliation_Manager::$db_version );
    }
    
    
    
    /**
     *  updates database using table definitions in table_definitions_sql.php
     */
    private function create_tables(){
        
        require_once 'table_definitions_sql.php';
        
        if (!function_exists('dbDelta'))
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        
        foreach (get_table_definitions() as $aTable) {
            dbDelta($aTable);
        }
    }

    
    
    
}
