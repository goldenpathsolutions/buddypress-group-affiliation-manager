<?php

namespace gps\gam\model\data_object;

use gps\gam\model\dao\Group_DAO;
use gps\gam\model\dao\Affiliation_Collection_DAO;
use gps\gam\model\dao\Abstract_Data_Access_Object;


require_once (dirname(__FILE__) . '/Abstract_Data_Object.php');
require_once (dirname(dirname(__FILE__)) . '/dao/Group_DAO.php');
require_once (dirname(dirname(__FILE__)) . '/dao/Abstract_Data_Access_Object.php');


/*
 * Group Data Object
 * 
 * Contains info about BuddyPress Groups and Group Hierarchies
 */

class Group_DO extends Abstract_Data_Object {

    var $creator = null;        //User_DO: creator_id
    var $name = '';             //String: name of this group
    var $slug = '';             //String: unique string identifier used in URLs
    var $description = '';      //String: description of this group
    var $status = '';           //String (ENUM: private, ...)
    var $enable_forum = false;  //boolean: true = uses a form
    var $date_created = '';     //String: yyyy-mm-dd
    var $parent = null;         //Group_DO: parent Group of this Group. parent_id
    
    function __construct($id = Group_DAO::NEW_OBJECT) {
        parent::__construct($id);
    }

    public function get_creator() {
        $this->hydrate();
        return $this->creator;
    }

    public function get_name() {
        $this->hydrate();
        return $this->name;
    }

    public function get_slug() {
        $this->hydrate();
        return $this->slug;
    }

    public function get_description() {
        $this->hydrate();
        return $this->description;
    }

    public function get_status() {
        $this->hydrate();
        return $this->status;
    }

    public function get_enable_forum() {
        $this->hydrate();
        return $this->enable_forum;
    }

    public function get_date_created() {
        $this->hydrate();
        return $this->date_created;
    }

    public function get_parent() {
        $this->hydrate();
        return $this->parent;
    }

    public function set_creator($creator) {
        $this->creator = $creator;
        return $this;
    }

    public function set_name($name) {
        $this->name = $name;
        return $this;
    }

    public function set_slug($slug) {
        $this->slug = $slug;
        return $this;
    }

    public function set_description($description) {
        $this->description = $description;
        return $this;
    }

    public function set_status($status) {
        $this->status = $status;
        return $this;
    }

    public function set_enable_forum($enable_forum) {
        $this->enable_forum = $enable_forum;
        return $this;
    }

    public function set_date_created($date_created) {
        $this->date_created = $date_created;
        return $this;
    }

    public function set_parent(Group_DO $parent) {
        $this->parent = $parent;
    }

    /**
     * returns an ordered list of this group's ancestors from oldest to newest
     * @return array(Group_DO)
     */
    public function get_ancestors() {

        $ancestors = array();
        $parent = $this->getParent();

        while (isset($parent)) {
            array_push($ancestors, $parent);
            $parent = $parent->getParent();
        }
        
        return $ancestors;
    }
    
    /**
     * populates array with all affiliation collections owned by this group
     */
    public function get_affiliation_collections(){
        
        require_once (dirname(dirname(__FILE__)) . '/dao/Affiliation_Collection_DAO.php');

        $collections = Affiliation_Collection_DAO::get_by_group($this);
        
        return $collections;
    }

    protected function hydrate() {
        if (!$this->is_hydrated != Abstract_Data_Access_Object::NEW_OBJECT) 
            Group_DAO::load( $this );
    }
    
    

}
