<?php

require_once TRIO_DIR.'/whereis.php';

/**
 * A hidden form field
 *
 * @author Cornel Borina <cornel@scoalaweb.com>
 * @package 3oScript
 */
class Hidden extends Input{
    public function __construct($name, $default='', $id=''){
        parent::__construct('hidden', $name, $default, $id);
    }

    public function toHtml($echo = TRUE){
        return Element::toHtml($echo);
    }

    public function toCSS($echo = null){
        return '';
    }
}