<?php
require_once TRIO_DIR.'/whereis.php';

/**
 * Description of HtmlHeading
 *
 * @author cornel
 */
class HtmlHeading extends HtmlElement{
    public function __construct($level = 1, $content = '', $id = '') {
        if (!is_numeric($level) || !preg_match('/^[1-6]$/', $level))
        {
            $id = $content;
            $content = $level;
            $level = 1;
        }
        parent::__construct('h'.$level, $id);
        
        $this->setText($content);
    }
}