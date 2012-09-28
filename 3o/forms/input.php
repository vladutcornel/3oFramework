<?php
include_once('lib/forms/formElement.php');

class Input extends FormElement{
    public function __construct($type, $name, $default = '', $id = ''){
        parent::__construct('input', $id);

        $this->setAttribute('type', $type);
        $this->setAttribute('name', $name);
        if("" == $default ){
            $this->setAttribute('value', $this->httpPost($name));
        }else {
            $this->setAttribute('value',$default);    
        }
        

        $this->setSingleTag(true);
    }
}