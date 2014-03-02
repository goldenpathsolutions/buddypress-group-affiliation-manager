<?php
namespace gps\gam\model\data_object;

use gps\gam\model\dao\Abstract_Data_Access_Object;

require_once (dirname(__FILE__) . '/Abstract_Data_Object.php');
require_once (dirname(dirname(__FILE__)) . '/dao/Abstract_Data_Access_Object.php');

/* 
 * Abstract Data Object
 * 
 * This holds attributes common to all Data Objects
 * 
 * Author: Patrick Jackson, Golden Path Solutions
 * Date: 2013-11-16
 */

abstract class Abstract_Data_Object {
    
    var $id = Abstract_Data_Access_Object::NEW_OBJECT;
    var $is_hydrated = false;
    
    function __construct($id) {
        $this->id = $id;
    }
    
    abstract protected function hydrate();

    /**
     * Get this object's id from database
     * 
     * @return type
     */
    public function get_id(){ return $this->id; }
    
    /**
     * Setting a hydrated object with a new id will set is_hydrated to false.
     * It shouldn't be possible to hydrate an object with id=0.
     * 
     * @param type $id
     * @return \gps\gam\model\data_object\Abstract_Data_Object
     */
    public function set_id($id){
        if( !($this->id === 0 || $this->id === $id ) ){
            $this->is_hydrated = false;
        }

        $this->id = $id;
        return $this;
    }
    
    protected function is_hydrated(){ return $is_hydrated; }
}


?>