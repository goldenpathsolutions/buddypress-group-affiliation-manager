<?php

namespace gps\gam;

use gps\gam\installer\Installer;
use gps\gam\model\data_object\Group_DO;
use gps\gam\controllers\Affiliation_Collection_Controller;


/* 
 * convenience class to hold useful variables and functions
 */

if (!class_exists('Group_Affiliation_Manager')) {
class Group_Affiliation_Manager {
    
    static $version = 1.0;
    static $db_version = 1.0;
    var $options = array();
    var $view_parameters = array();

    
    
    /**
     * Initializing object
     *
     * Plugin register actions, filters and hooks.
     */

   function __construct() {

       // Activation hook
       require_once ( dirname( __FILE__ ) . '/installer/Installer.php');
       register_activation_hook(__FILE__, array( new Installer(), 'install'));
       
       //Load the JavaScript
       add_action('wp_enqueue_scripts', array($this, 'gam_script') );
       
       //Load the Style Sheet
       add_action('wp_enqueue_scripts', array($this, 'gam_style') );
       
       //Load Controllers
       require_once ( dirname( __FILE__ ) . '/controllers/Affiliation_Collection_Controller.php');
       add_action( 'wp_ajax_affiliation_collection_controller_handle', array( $this, 'affiliation_collection_controller_handle' ) );
       
       //Load BuddyPress Groups Extension
       add_action( 'bp_include',  array($this, 'my_plugin_init'));

       //Deactivation hook
       register_deactivation_hook(__FILE__, array($this, 'uninstall'));

   }
   
   public function my_plugin_init(){
       require( dirname( __FILE__ ) . '/buddypress/Group-Affiliation-Manager-BPGE.php' );
       bp_register_group_extension( 'gps\gam\buddypress\Group_Affiliation_Manager_BPGE' );
   }
   
   public function gam_script() {
              
        if ( is_page() && is_page( 'groups' ) ){
            wp_enqueue_script(  
                'group-affiliation-manager-script',  
                plugins_url() . '/gps-group-affiliation-manager/views/js/group-affiliation-manager.js',
                array('jquery'),  
                '1.0',  
                true  
            );
        }
    }
    
    public function gam_style() {  
              
        if ( is_page() && is_page( 'groups' ) ){
            wp_enqueue_style(  
                'group-affiliation-manager-style',  
                plugins_url() . '/gps-group-affiliation-manager/views/css/style.css',
                array(),
                '1.0'
            );
        }
    }
   
   /**
    * Set the current_group view parameter
    * 
    * @param type $group_id
    */
   public function set_current_group( $group_id ){
       
       require_once ( dirname(__FILE__) . '/model/data_object/Group_DO.php');
   
        //Make sure $current_group is set
        //don't re-invent the wheel if $current_group is already set
        $current_group = $this->view_parameters['current_group'];
        if (!isset( $current_group ) ){
            $current_group = new Group_DO( $group_id );
            $this->view_parameters['current_group'] = new Group_DO( $group_id );
        }        
   }
   
   public function affiliation_collection_controller_handle(){
       die( Affiliation_Collection_Controller::handle() );
   }
        
    /**
     * Handle Uninstallation
     */
    public function uninstall(){
        //do nothing
    }
}
}