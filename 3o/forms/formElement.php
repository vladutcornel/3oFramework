<?php
include_once('lib/HtmlElement.php');

class FormElement extends HtmlElement{
    private $label;//Element
    private $tip;//Element

    public function __construct($type, $name, $id = ''){
        parent::__construct($type, $id);

        $this->setAttribute('name', $name);

        $this->label = new Element('label');
        $this->label->setAttribute('for', $this->getId());
    
        $this->tip = new Element('span',$this->getId().'tip');
        
    }

    /**
    * Access the <label> element from outside
    */
    public function getLabel(){
        return $this->label;
    }

    /**
     * Access the infobar tip element from outside. The infobar is intended to
     * be a information text after the actual element
     */
    public function getInfobar(){
        return $this->tip;
    }

    public function setLabel($text){
        $this->label->setText($text);
        return $this;
    }
    public function setInfotext($text){
        $this->tip->setText($text);
        return $this;
    }
    
    public function setValue($new_value) {
        $this->setAttribute('value', $new_value);
        return $this;
    }

    /**
    * prints and/or returns the html code for this form element.
    * The label is printed before the element while the infobar is printed after
    */
    public function toHtml($echo = TRUE){
        $html = $this->label->toHtml(FALSE);
        $html.= parent::toHtml(false);
        $html.= $this->tip->toHtml(false);

        if($echo){
            echo $html;
        }
        return $html;
    }
    
    
    public function toCSS($echo = true){
        $css = $this->label->toCSS(false);
        $css.=parent::toCSS(false);
        $css.= $this->tip->toCSS(false);
        
        if($echo) {
            echo $css;
        }
        
        return $css;
    }
}