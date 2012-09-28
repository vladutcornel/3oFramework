<?php
require_once("lib/HtmlElement.php");
require_once('lib/forms/textField.php');
require_once('lib/forms/passwordField.php');
require_once('lib/forms/button.php');
require_once('lib/forms/textarea.php');
require_once('lib/forms/hidden.php');

class Form extends HtmlElement{
    private $hidden = array();
    public function __construct($action, $method = 'get', $id=''){
        parent::__construct('form',$id);
        $this->setAttribute('action', $action);
        $this->setAttribute('method', 'post');
    }
    
    /**
     * Sets the value for the FormElement identified by field name
     * @param string $field tag's "name" value of the field
     * @param string $newValue
     */
    public function setValue($field, $newValue) {
        $found = false;
        
        foreach ($this->childs as $child){
            if (! $child instanceof FormElement) continue;
            
            if ($child->getAttribute("name") == $field){
                $child->setValue($newValue);
                $found = true;
            }//if
        }//foreach
        
        if (!$found) {
            $hidden = new Hidden($field, $newValue);
            $this->addChild($hidden);
        }
        
        return $this;
    }
}