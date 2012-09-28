<?php
require_once('lib/HtmlElement.php');

class Link extends HtmlElement{

    public function __construct($destination, $content = NULL, $id = ''){
        parent::__construct('a',$id);

        $this->setAttribute('href', $destination);
        if ($content === NULL) {
            $this->setText($destination);
        }else {
            $this->setText($content);
        }

    }

    public function getHref(){
        return $this->getAttribute('href');
    }
}