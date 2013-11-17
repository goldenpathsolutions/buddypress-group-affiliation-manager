<?php
namespace gps\gam;

/**
 * Plugin Name: GPS Group Affiliation Manager
 * Description: Adds functionality to Groups to manage user affiliations with that group, and group affiliations with one another (supports Group Hierarchy).  So, it supports things like an Org structure with internal taxonomy, member titles, roles, and inherited permissions.
 * Tags: buddypress, bp-group-hierarchy
 * Version: 0.1
 * Author: Patrick Jackson (Golden Path Solutions)
 * Author URI: http://www.goldenpathsolutions.com
 * License: This plugin is the property of Golden Path Solutions with all rights reserved, copyright 2013.
 */


/*****************************************************************************
 * create and instantiate convenience class...
 */
require_once( dirname(__FILE__) . '/classes/group-affiliation-manager.php');

$group_affiliation_manager =  new Group_Affiliation_Manager();


/*****************************************************************************
 * register shortcodes
 */
/*
require_once ( dirname( __FILE__ ) . '/gps-gam-shortcodes.php');

//gam-cruda - UI for CRUD operations on Affiliations and Collections
add_shortcode( 'gam-cruda', 'gam_cruda' );
add_filter('the_posts', 'conditionally_add_gam_cruda_scripts_styles'); //
*/

?>