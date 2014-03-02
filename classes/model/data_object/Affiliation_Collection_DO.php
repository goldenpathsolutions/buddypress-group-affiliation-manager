<?php

namespace gps\gam\model\data_object;

use \gps\gam\model\dao\Affiliation_Collection_DAO;
use \gps\gam\model\dao\Affiliation_DAO;
use gps\gam\model\dao\Abstract_Data_Access_Object;

require_once (dirname(__FILE__) . '/Abstract_Data_Object.php');
require_once (dirname(dirname(__FILE__)) . '/dao/Affiliation_Collection_DAO.php');
require_once (dirname(dirname(__FILE__)) . '/dao/Affiliation_DAO.php');
require_once (dirname(dirname(__FILE__)) . '/dao/Abstract_Data_Access_Object.php');

/* 
 * Affiliation Collection Data Object
 * 
 * Affiliation Collections allow one to group Affiliations into related, named Collections
 * 
 */

class Affiliation_Collection_DO extends Abstract_Data_Object{
    
    var $creator = null;        //User_DO: the creator of this collection
    var $group = null;          //Group_DO: the group that owns this collection
    var $name = '';             //the name of this collection
    var $description = '';      //description of this collection
    var $inheritable = false;   //if true, collection my be used by subgroups
    var $date_created = '';     //date collection was created: yyyy-mm-dd
 
    function __construct($id = Affiliation_Collection_DAO::NEW_OBJECT) {
        parent::__construct($id);
    }
    
    public function get_creator() {
        $this->hydrate();
        return $this->creator;
    }

    public function get_group() {
        $this->hydrate();
        return $this->group;
    }

    public function get_name() {
        $this->hydrate();
        return $this->name;
    }

    public function get_description() {
        $this->hydrate();
        return $this->description;
    }

    public function is_inheritable() {
        $this->hydrate();
        return $this->inheritable;
    }

    public function get_date_created() {
        $this->hydrate();
        return $this->date_created;
    }

    public function set_creator($creator) {
        $this->creator = $creator;
        return $this;
    }

    public function set_group($group) {
        $this->group = $group;
        return $this;
    }

    public function set_name($name) {
        $this->name = $name;
        return $this;
    }

    public function set_description($description) {
        $this->description = $description;
        return $this;
    }

    public function set_inheritable($inheritable) {
        $this->inheritable = $inheritable;
        return $this;
    }

    public function set_date_created($date_created) {
        $this->date_created = $date_created;
        return $this;
    }
    
    public function get_affiliations(){
        return Affiliation_DAO::get_by_affiliation_collection($this);
    }
    
    public function to_JSON(){
        $arr = array(
            'id'            => $this->get_id(),
            'name'          => $this->get_name(),
            'description'   => $this->get_description(),
            'inheritable'   => $this->is_inheritable(),
            'creator_id'    => $this->get_creator()->get_id(),
            'group_id'      => $this->get_group()->get_id(),
            'date_created'  => $this->get_date_created()
         );
        
        return json_encode($arr);
    }

    protected function hydrate() {
        if(!$this->is_hydrated && $this->get_id() != Abstract_Data_Access_Object::NEW_OBJECT){ 
            Affiliation_Collection_DAO::load( $this ); 
        }
    }

}