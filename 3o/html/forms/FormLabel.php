<?php

require_once TRIO_DIR.'/whereis.php';

/**
 * Description of FormLabel
 *
 * @author cornel
 */
class FormLabel extends HtmlElement {
    
    public function __construct($text = '', $for = '', $id = '') {
        parent::__construct('label', $id);
        
        $this->setFor($for);
        $this->setText($text);
    }
    
    /**
     * 
     * @param FormElement|string $element the element or element's ID
     * @return \FormLabel $this for method chaining
     */
    public function setFor($element)
    {
        if ($element instanceof FormElement)
        {
            // get the id of the form element
            $this->setAttribute('for', $element->getId());
        } else
        {
            // we assume we got some string (or something that can be converted to string)
            $this->setAttribute('for', "$element");
        }
        
        return $this;
    }
}