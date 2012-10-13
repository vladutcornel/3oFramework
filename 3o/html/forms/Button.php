<?php

require_once TRIO_DIR.'/whereis.php';

define('BUTTON_SUBMIT', 'submit');
define('BUTTON_STANDARD', 'button');

/**
 * A form button
 * @author Cornel Borina <cornel@scoalaweb.com>
 * @package 3oLibrary
 * @subpackage HTML
 * @todo When complex content is added (like images), transform this into < button >
 */
class Button extends Input{
    const SUBMIT = 'submit';
    const STANDARD = 'button';
    const STANDARD = 'reset';
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