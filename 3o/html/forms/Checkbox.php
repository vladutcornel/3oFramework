<?php
/**
 * Description of ClickableElement
 *
 * @author cornel
 */
class Checkbox extends Input{
    
    public function __construct($name, $default = 1, $id = '') {
        parent::__construct('checkbox', $name, $default, $id);
    }
    
    public function setValue($new_value) {
        if ($new_value == $this->getAttribute('value'))
        {
            $this->setAttribute('checked', 'checked');
        } else{
            $this->removeAttribute('checked');
        }
    }
    
    public function getValue() {
        if ('' != $this->getAttribute('checked'))
        {
            return $this->getAttribute('value');
        } else {
            return false;
        }
    }
}