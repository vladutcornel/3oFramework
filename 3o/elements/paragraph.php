<?php
require_once('lib/HtmlElement.php');

class Paragraph extends HtmlElement{

    public function __construct($content = '', $id = '') {
        parent::__construct('p',$id);
        $this->setText($content);
    }
}