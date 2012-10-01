<?php

require_once realpath(__DIR__.'/../HtmlElement.php');

require_once realpath(__DIR__.'/..//forms/textField.php');
require_once realpath(__DIR__.'/..//forms/passwordField.php');
require_once realpath(__DIR__.'/..//forms/button.php');
require_once realpath(__DIR__.'/..//forms/textarea.php');
require_once realpath(__DIR__.'/..//forms/hidden.php');


/**
 * A HTML form element.
 * It can set the value of a inner element. If the element does not exist,
 * a hidden element with that name and value is created
 * @author Cornel Borina <cornel@scoalaweb.com>
 * @package 3oScript
 */
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