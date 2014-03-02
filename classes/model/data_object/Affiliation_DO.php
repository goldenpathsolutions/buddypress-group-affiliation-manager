<?php

namespace gps\gam\model\data_object;

use gps\gam\model\dao\Affiliation_DAO;
use gps\gam\model\dao\Abstract_Data_Access_Object;


require_once (dirname(__FILE__) . '/Abstract_Data_Object.php');
require_once (dirname(dirname(__FILE__)) . '/dao/Affiliation_DAO.php');
require_once (dirname(dirname(__FILE__)) . '/dao/Abstract_Data_Access_Object.php');

/* 
 * Affiliation
 * 
 * This just stores info for one Affiliation object
 * 
 * Author: Patrick Jackson, Golden Path Solutions, Inc.
 * Date: 2013-11-16
 * Copyright: Golden Path Solutions, All Rights Reserved
 * 
 */

class Affiliation_DO extends Abstract_Data_Object{
    
    var $creator = null;                //User_DO the user that created this affiliation
    var $affiliation_collection = null; //Affiliation Collection object that contains this Affiliation
    var $name = null;                   //name of this Affiliation
    var $description = null;            //description of this Affiliation
    var $priority = 0;                  //int - priority of this affiliation in a list (order)
    var $date_created = null;           //Date yyyy-mm-dd
    
    
    //populate this object if given an id
    function __construct($id = Affiliation_DAO::NEW_OBJECT) {
        parent::__construct($id);
    }

    public function get_creator() {
        $this->hydrate();
        return $this->creator;
    }

    public function get_affiliation_collection() {
        $this->hydrate();
        return $this->affiliation_collection;
    }

    public function get_name() {
        $this->hydrate();
        return $this->name;
    }

    public function get_description() {
        $this->hydrate();
        return $this->description;
    }

    public function get_priority() {
        $this->hydrate();
        return $this->priority;
    }

    public function get_date_created() {
        $this->hydrate();
        return $this->date_created;
    }

    public function set_creator($creator) {
        $this->creator = $creator;
    }

    public function set_affiliation_collection(Affiliation_Collection_DO $affiliation_collection) {
        $this->affiliation_collection = $affiliation_collection;
    }

    public function set_name($name) {
        $this->name = $name;
    }

    public function set_description($description) {
        $this->description = $description;
    }

    public function set_priority($priority) {
        $this->priority = $priority;
    }

    public function set_date_created($date_created) {
        $this->date_created = $date_created;
    }

    protected function hydrate() {
        if(!$this->is_hydrated != Abstract_Data_Access_Object::NEW_OBJECT)
            Affiliation_DAO::load( $this );
    }
    
}
