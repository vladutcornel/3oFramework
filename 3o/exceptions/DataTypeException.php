<?php

/**
 * 
 */
class DataTypeException extends Exception {
    private $parent_object;
    private $parent_name;
    private $field_name;
    public function __construct($parent, $field = ""){
        parent::__construct("Invalid data type provided in class " . $this->parent_name . " File: {$this->file}:{$this->line} ");
        
        if (is_object($parent)){
            $this->parent_object = $parent;
            $this->parent_name = get_class($parent);
        } else {
            $this->parent_name = "".$parent;
        }
        
        $this->field_name = $field;
    }
    
    public function __toString() {
        parent::__toString(). " in class " . $this->parent_name . " File: {$this->file}:{$this->line} ";
    }
}