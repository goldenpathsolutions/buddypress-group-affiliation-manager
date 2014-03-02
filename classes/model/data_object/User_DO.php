<?php

namespace gps\gam\model\data_object;

use gps\gam\model\dao\User_DAO;

require_once (dirname(__FILE__) . '/Abstract_Data_Object.php');
require_once (dirname(dirname(__FILE__)) . '/dao/User_DAO.php');

/* 
 * User Data Object
 * 
 * Contains useful info about users and objectifies them.
 * 
 */


class User_DO extends Abstract_Data_Object {
    
    var $user_login = '';       //username used to uniquely identify user
    var $user_pass = '';        //encrypted user password
    var $user_nicename = '';    //not sure what this is
    var $user_email = '';       //user's primary email address
    var $user_url = '';         //user's favorite url
    var $user_registered = '';  //date & time user registered: yyyy-mm-dd HH:mm:ss
    var $user_activation = '';  //not sure what this is
    var $user_status = 0;       //not sure what this is
    var $display_name = '';     //used to reference use publically on site
    var $spam = false;          //boolean: if true, user is flagged as a spammer (?)
    var $deleted = false;       //boolean: if true, user account is in deleted state
    
    
    function __construct($id = User_DAO::NEW_OBJECT) {
        parent::__construct($id);
    }
    
    public function get_user_login() {
        $this->hydrate();
        return $this->user_login;
    }

    public function get_user_pass() {
        $this->hydrate();
        return $this->user_pass;
    }

    public function get_user_nicename() {
        $this->hydrate();
        return $this->user_nicename;
    }

    public function get_user_email() {
        $this->hydrate();
        return $this->user_email;
    }

    public function get_user_url() {
        $this->hydrate();
        return $this->user_url;
    }

    public function get_user_registered() {
        $this->hydrate();
        return $this->user_registered;
    }

    public function get_user_activation() {
        $this->hydrate();
        return $this->user_activation;
    }

    public function get_user_status() {
        $this->hydrate();
        return $this->user_status;
    }

    public function get_display_name() {
        $this->hydrate();
        return $this->display_name;
    }

    public function get_spam() {
        $this->hydrate();
        return $this->spam;
    }

    public function get_deleted() {
        $this->hydrate();
        return $this->deleted;
    }

    public function set_user_login($user_login) {
        $this->user_login = $user_login;
        return $this;
    }

    public function set_user_pass($user_pass) {
        $this->user_pass = $user_pass;
        return $this;
    }

    public function set_user_nicename($user_nicename) {
        $this->user_nicename = $user_nicename;
        return $this;
    }

    public function set_user_email($user_email) {
        $this->user_email = $user_email;
        return $this;
    }

    public function set_user_url($user_url) {
        $this->user_url = $user_url;
        return $this;
    }

    public function set_user_registered($user_registered) {
        $this->user_registered = $user_registered;
        return $this;
    }

    public function set_user_activation($user_activation) {
        $this->user_activation = $user_activation;
        return $this;
    }

    public function set_user_status($user_status) {
        $this->user_status = $user_status;
        return $this;
    }

    public function set_display_name($display_name) {
        $this->display_name = $display_name;
        return $this;
    }

    public function set_spam($spam) {
        $this->spam = $spam;
        return $this;
    }

    public function set_deleted($deleted) {
        $this->deleted = $deleted;
        return $this;
    }


    protected function hydrate() {
        if(!$this->is_hydrated != Abstract_Data_Access_Object::NEW_OBJECT )
            User_DAO::load( $this );
    }

}