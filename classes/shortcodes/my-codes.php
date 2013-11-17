<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/************************************************************************
 *
 *  [gam-cruda] =   Function that does the work of rendering the Affiliation
 *                  CRUD UI
 */

//check to see whether this shortcode is used, and add scripts/styles if it is

function conditionally_add_gam_cruda_scripts_styles($posts){
	if (empty($posts)) return $posts;
 
	$shortcode_found = false;
	foreach ($posts as $post) {
		if (stripos($post->post_content, '[gam-cruda]') !== false) {
			$shortcode_found = true; // bingo!
			break;
		}
	}

	if ($shortcode_found) {
            
            $this_plugin_url = plugins_url() . '/gps-group-organizations-affiliations';
            
            if(!is_admin()) {  
                wp_enqueue_script(  
                    'gam_crud_affiliations_js',  
                    $this_plugin_url . '/templates/js/crud-affiliations.js',  
                    'jquery'
                );
            }  
        }
        
        return $posts;
}

// Handle the [gam-cruda] shortcode
function gam_cruda( $atts ){
    
    require_once ( dirname( __FILE__ ) . '/templates/crud-affiliations.php');
        
    return $gam_cruda;
    
}