<?php
require_once('lib/forms/input.php');

define('BUTTON_SUBMIT', 'submit');
define('BUTTON_STANDARD', 'button');

class Button extends Input{
    const SUBMIT = 'submit';
    const STANDARD = 'button';
    public function __construct( $type, $default = '',$name = '', $id = ''){
        parent::__construct($type, $name, $default, $id);

    }
    
    public function setLabel($text) {
        $this->setValue($text);
    }
    
    /**
     * bypass the FormElement's Label+Info HTML
     */
    public function toHtml($echo = TRUE){
        return Element::toHtml($echo);
    }
    /**
     * bypass the FormElement's Label+Info CSS
     */
    public function toCss($echo = TRUE){
        return Element::toCss($echo);
    }
}