<?php

require_once TRIO_DIR.'/whereis.php';

/**
 * A page paragraph
 * @author Cornel Borina <cornel@scoalaweb.com>
 * @package 3oScript
 */
class Paragraph extends HtmlElement{

    public function __construct($content = '', $id = '') {
        parent::__construct('p',$id);
        $this->setText($content);
    }
}