<?php
namespace gps\gam\buddypress;

use \BP_Group_Extension;

/*****************************************************************************
 * Integrates Group Affiliation Manager with BuddyPress Groups
 */

class Group_Affiliation_Manager_BPGE extends BP_Group_Extension {
   
    function __construct() {
                
        $this->create_step_position = 22;
        $this->nav_item_position    = 32;
	$this->slug                 = "affiliation-manager";
	$this->name                 = "Affiliation Manager";
	$this->enable_nav_item      = false;

	/*if (isset($bp->groups->current_group->id)) {
            if ( groups_is_user_member( $bp->loggedin_user->id, $bp->groups->current_group->id ) ) {

                // First check if the old value
                $enabled = groups_get_groupmeta( $bp->groups->current_group->id, 'wpmudevchatbpgroupenable' );
                if (!empty($enabled)) {
                    echo "here!<br />";
                    groups_delete_groupmeta( $bp->groups->current_group->id, 'wpmudevchatbpgroupenable' );
                    groups_update_groupmeta( $bp->groups->new_group_id, self::settings_slug .'_enable', $enabled );
                }

                $enabled = groups_get_groupmeta( $bp->groups->current_group->id, self::settings_slug .'_enable', true );
                if ($enabled == "yes") {
                    $this->enable_nav_item = true;
                }
            }
	}*/
        
        
       $args = array(
        	'slug' 			=> 	$this->slug,
        	'name'                  => 	$this->name,
		'enable_nav_item'	=>	$this->enable_nav_item,
        	'nav_item_position' 	=> 	$this->nav_item_position,
        	'screens'               => 	array(
                                                    'edit' => array(
                                                                    'name' => $this->name,
                                                                    // Changes the text of the Submit button
                                                                    // on the Edit page
                                                                    //'submit_text' => __('Submit', $wpmudev_chat->translation_domain),
                                                                ),
                                                    'create' => array(
                                                                    'position' => $this->create_step_position,
            							),
                                                    'admin' => array(
                                                                    'name' =>$this->name,
                                                                )
        					),
    		);
        parent::init( $args );
   }
   
   function create_screen($group_id = null) {
       
       global  $group_affiliation_manager,
               $GPS_GAM_DIR;
       
       if ($group_id == 0 || $group_id == null) {
            $group_id = parent::get_group_id();
        }
        parent::create_screen($group_id);  //do whatever the parent does with this first...
        
        //store some parameters used by the view
        $group_affiliation_manager->set_current_group( $group_id );
                
       require_once ( $GPS_GAM_DIR . '/views/group_create.php');
    }
    
    function create_screen_save($group_id = null) {
        parent::create_screen_save($group_id); //do whatever the parent does with this first...
        echo 'Show this after saving!';
    }
    
    function edit_screen($group_id = null) {
        parent::edit_screen($group_id);   //do whatever the parent does with this first...     
        echo 'Edit this attribute for this group here!';
    }
    
    function edit_screen_save($group_id = null) {
        parent::edit_screen_save($group_id); //do whatever the parent does with this first...
        echo 'Show this after hitting save on the edit screen!';
    }
    
    function admin_screen($group_id = null) {
        parent::admin_screen($group_id); //do whatever the parent does with this first...
        echo 'Do stuff on the Admin screen for this group!';
    }
    
    function admin_screen_save($group_id = null) {
        parent::admin_screen($group_id); //do whatever the parent does with this first...
        echo 'Show this after hitting save on the Admin Screen!';
    }
    
    
    
}

?>