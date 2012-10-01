<?php
require_once realpath(__DIR__.'/../forms/input.php');

/**
 * A password form field
 * 
 * @author Cornel Borina <cornel@scoalaweb.com>
 * @package 3oScript
 */
class PasswordField extends Input{
    public function __construct($name, $default='', $id=''){
        parent::__construct('password', $name, $default, $id);
    }

}