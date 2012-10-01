<?php
require_once realpath(__DIR__.'/../forms/input.php');

/**
 * An input text field
 * @author Cornel Borina <cornel@scoalaweb.com>
 * @package 3oScript
 */
class TextField extends Input{
    public function __construct($name, $default='', $id=''){
        parent::__construct('text', $name, $default, $id);
    }

}