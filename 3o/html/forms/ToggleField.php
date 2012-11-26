<?php
/**
 * A HTML Checkbox.
 *
 * @author Cornel Borina <cornel@scoalaweb.com>
 * @package 3oLibrary
 * @subpackage HTML
 */
class Checkbox extends Input{
    /**
     * @param string $name the name of the field
     * @param mixed $value the value of the checkbox field
     * @param string $id
     */
    public function __construct($name, $default = 1, $id = '') {
        parent::__construct('checkbox', $name, $default, $id);
        $this->setAttribute('value', $default);
    }
    
    /**
     * Marks the checkbox as checked if the provided value matches the field value
     * Otherwise, unchecks it.
     * To really set the value, use Checkbox::setAttribute(...)
     * @param type $new_value
     * @return \Checkbox
     */
    public function setValue($new_value) {
        if ($new_value == $this->getAttribute('value'))
        {
            $this->setAttribute('checked', 'checked');
        } else{
            $this->removeAttribute('checked');
        }
        
        return $this;
    }
    
    /**
     * Returns the value of the field if checked or false if not
     * @return boolean|string
     */
    public function getValue() {
        if ('' != $this->getAttribute('checked'))
        {
            return $this->getAttribute('value');
        } else {
            return false;
        }
    }
}