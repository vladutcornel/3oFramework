<?php

require_once TRIO_DIR.'/whereis.php';

/**
 * An input form field
 *
 * @author Cornel Borina <cornel@scoalaweb.com>
 * @package 3oLibrary
 * @subpackage HTML
 */
class Input extends FormElement{
    public function __construct($type, $name, $default = '', $id = ''){
        parent::__construct('input', $name, $id);

        $this->setAttribute('type', $type);
        $this->setAttribute('name', $name);
        if('' == $default ){
            $this->setValue(TGlobal::request($name));
        }else {
            $this->setValue($default);
        }


        $this->setSingleTag(true);
    }
}