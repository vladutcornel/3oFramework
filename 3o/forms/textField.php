<?php
require_once('lib/forms/input.php');

class TextField extends Input{
    public function __construct($name, $default='', $id=''){
        parent::__construct('text', $name, $default, $id);
    }

}