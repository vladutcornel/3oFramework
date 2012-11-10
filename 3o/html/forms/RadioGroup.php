<?php

require_once TRIO_DIR . '/whereis.php';

/**
 * A group of check boxes that are not necesary for direct display
 *
 * @author cornel
 */
class RadioGroup extends CheckableFormElements {
    public function __construct($name, $id = '') {
        parent::__construct(self::RADIO, $name, $id);
    }
}