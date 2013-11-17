<?php

namespace gps\gam;

/* 
 * Group Affiliation Manager DAO
 * 
 * This Data Access Object (DAO) organizes database access for the Group Affiliation Manager
 */

class Affiliation_DAO {
    
    function __construct(){
        //do nothing
    }
    
    /**
     * Returns a list of Affiliation objects for the given $group_id.
     * returns null if $group_id is null
     * @param type $group_id
     * @return null
     */
    public function get_affiliations($group_id = null){
        if (!$group_id) {
            return null;
        }
        
        
        
        
    }
    
}