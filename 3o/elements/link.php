<?php
require_once realpath(__DIR__.'/../HtmlElement.php');

/**
 * A page anchor
 * @author Cornel Borina <cornel@scoalaweb.com>
 * @package 3oScript
 */
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