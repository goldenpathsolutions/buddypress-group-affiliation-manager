<?php
namespace gps\gam\installer;

/* 
 * this snippet holds all of the table definition sql in an array
 */

function get_table_definitions(){

    global $wpdb;

    $my_tables = array(


        //gam_affiliation_collections - Affiliation Collections are groups of names used to describe member affiliations to groups

        "CREATE TABLE " . $wpdb->prefix . "gam_affiliation_collections (
           id bigint NOT NULL AUTO_INCREMENT,
           creator_id bigint NOT NULL,
           group_id bigint NOT NULL,
           name tinytext NOT NULL,
           description text NOT NULL,
           is_inheritable boolean NOT NULL,
           date_created datetime NOT NULL,
           UNIQUE KEY id (id),
           KEY creator_id (creator_id)
         );",

        //gam_affiliations - Affiliations are the names a member can have in association with a group

        "CREATE TABLE " . $wpdb->prefix . "gam_affiliations (
           id bigint NOT NULL AUTO_INCREMENT,
           creator_id bigint NOT NULL,
           collection_id bigint NOT NULL,
           name tinytext NOT NULL,
           description text NOT NULL,
           priority tinyint NOT NULL,
           date_created datetime NOT NULL,
           UNIQUE KEY id (id),
           KEY creator_id (creator_id)
         );"


    );
    
    return $my_tables;
}