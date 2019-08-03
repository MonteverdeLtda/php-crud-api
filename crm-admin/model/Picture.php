<?php 
/* *******************************
 *
 * Developer by FelipheGomez
 *
 * Git: https://github.com/Feliphegomez/crm-crud-api-php
 * *******************************
 */

class Picture extends EntidadBase {
    private $id;
    private $name;
    private $size;
    private $data;
    private $type;
    private $created;
    private $updated;
     
    public function __construct() {
        $table = TBL_PICTURES;
        parent::__construct($table);
    }
	
	public function __toString(){
		return json_encode($this);
	}
	
	public function getId(){
		return ($this->id == null) ? 0 : (int) $this->id;
	}
	
}