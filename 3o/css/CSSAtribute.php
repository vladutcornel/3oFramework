<?php
require_once TRIO_DIR.'/whereis.php';
/**
 * A CSSAttribute is expected to return one or more CSS-compatible attributes
 * @author Cornel Borina <cornel@scoalaweb.com>
 */
interface CSSAtribute {
    /**
     * Return in the form [attribute_name => attribute_value]
     * @return array The CSS attribute array
     */
    public function cssArray();
}