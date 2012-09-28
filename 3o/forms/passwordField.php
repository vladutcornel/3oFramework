<?php
require_once('lib/forms/input.php');

class PasswordField extends Input{
    public function __construct($name, $default='', $id=''){
        parent::__construct('password', $name, $default, $id);
    }

}