<?php
include_once('lib/forms/formElement.php');

class Textarea extends FormElement{
    public function __construct($name, $default = '', $id = ''){
        parent::__construct('textarea', $id);
        
        $this->setSingleTag(false);

        $this->setAttribute('name', $name);
        if("" == $default ){
            $this->setAttribute('value', $this->httpPost($name));
        }else {
            $this->setAttribute('value',$default);    
        }
        
    }
    
    public function setValue($newValue) {
        $this->setText(htmlentities($newValue));
    }
}