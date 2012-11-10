<?php

require_once TRIO_DIR . '/whereis.php';

/**
 * A group of check boxes that are not necesary for direct display
 *
 * @author cornel
 */
class CheckboxGroup extends CheckableFormElements {
    public function __construct($name, $id = '') {
        parent::__construct(self::CHECKBOX, $name, $id);
    }
}