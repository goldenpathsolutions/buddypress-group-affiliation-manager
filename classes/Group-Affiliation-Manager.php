<?php

namespace gps\gam;

use gps\gam\installer\Installer;

/* 
 * convenience class to hold useful variables and functions
 */

if (!class_exists('Group_Affiliation_Manager')) {
class Group_Affiliation_Manager {
    
    static $version = 1.0;
    static $db_version = 1.0;
    var $options = array();
    
    
    /**
     * Initializing object
     *
     * Plugin register actions, filters and hooks.
     */

   function __construct() {

       // Activation hook
       require_once ( dirname( __FILE__ ) . '/installer/Installer.php');
       register_activation_hook(__FILE__, array( new Installer(), 'install'));
       
       //Load BuddyPress Groups Extension
       add_action( 'bp_include',  array(&$this, 'my_plugin_init'));

       //Deactivation hook
       register_deactivation_hook(__FILE__, array(&$this, 'uninstall'));

   }
   
   function my_plugin_init(){
       require( dirname( __FILE__ ) . '/buddypress/Group-Affiliation-Manager-BPGE.php' );
       bp_register_group_extension( 'gps\gam\buddypress\Group_Affiliation_Manager_BPGE' );
   }
        
        
    /**
     * Handle Uninstallation
     */
    function uninstall(){
        //do nothing
    }
}
}