<?php

require_once realpath(__DIR__.'/../HtmlElement.php');

/**
 * A HTML table.
 * It includes simple manipulation of the Table cells and 3 sections (thead, tbody, tfoot)
 * @author Cornel Borina <cornel@scoalaweb.com>
 * @package 3oScript
 */
class Table extends HtmlElement {
    const HEAD = "head";
    const BODY = "body";
    const FOOT = "foot";
    /**
     * @var int[]
     */
    private $numRows = array( 'head'=>0, 'foot'=>0, 'body'=>0);
    /**
     * @var int
     */
    private $numCols = 0;
    
    /**
     * @var HtmlElement
     */
    private $thead;
    /**
     * @var HtmlElement
     */
    private $tfoot;
    /**
     * @var HtmlElement
     */
    private $tbody;
    
    /**
     * @var HtmlElement[][]
     */
    private $rows = array('head'=>array(),  'foot'=>array(), 'body'=>array());
    /**
     * @var HtmlElement[][]
     */
    private $cells = array('head'=>array(),  'foot'=>array(), 'body'=>array());
    
    public function __construct($id = '') {
        parent::__construct("table",$id);
        $this->thead = new HtmlElement("thead");
        $this->tfoot = new HtmlElement("tfoot");
        $this->tbody = new HtmlElement("tbody");
        
        $this->addChild($this->thead);
        $this->addChild($this->tbody);
        $this->addChild($this->tfoot);
    }
    
    /**
     * Gets the HtmlElement for the specified cell.
     * The table is automaticaly expanded to match the size
     * @param int $row >0
     * @param int $col >0
     * @param string $region Table::HEAD, Table::BODY or Table::FOOT
     * @return HtmlElement
     */
    public function cell($row, $col, $region = Table::BODY) {
        if ($row > $this->numRows[$region]){
            $this->expandRows($row - $this->numRows[$region], $region);
        }
        
        if ($col > $this->numCols){
            $this->expandCells($col - $this->numCols);
        }
        return $this->cells[$region][$row-1][$col-1];
    }
    
    /**
     * Expands the number of rows of thespcified region
     * @param int $delta the number of rows to be added
     */
    private function expandRows($delta, $region)
    {
        $parent = $this->getRegionParent($region);
        $cellTag = "td";
        if ($region == Table::HEAD) {
            $cellTag = "th";
        }
        
        for ($i = 0; $i < $delta; $i++){
            // create table row
            $row =
                new HtmlElement("tr");
            
            // create table cells for the row
            for ($col = 0; $col < $this->numCols; $col++){
                $cell = new HtmlElement($cellTag);
                $this->cells[$region][$this->numRows[$region]][$col] = $cell;
                $row->addChild($cell);
            }
            
            // register the row
            $this->rows[$region][$this->numRows[$region]] = $row;
            $parent->addChild($row);
            
            // next row
            $this->numRows[$region] ++;
        }
    }
    
    /**
     * Expands the number of columns for the specified region or for the entire table
     * @param int $delta the number of columns to be added
     * @param string|null $region A valid table region or null
     */
    private function expandCells($delta, $region = null)
    {
        if (is_null($region)) {
            $this->expandCells($delta, Table::HEAD);
            $this->expandCells($delta, Table::BODY);
            $this->expandCells($delta, Table::FOOT);
            $this->numCols += $delta;
            return;
        }
        
        $parent = $this->getRegionParent($region);
        $cellTag = "td";
        if (Table::HEAD == $region){
            $cellTag = "th";
        }
        
        for ($rownr = 0; $rownr < $this->numRows[$region]; $rownr++){
            $row = $this->rows[$region][$rownr];
            for ($i = 0; $i < $delta; $i++) {
                $colnr = $this->numCols + $i;
                $cell = new HtmlElement($cellTag);
                $this->cells[$region][$rownr][$colnr] = $cell;
                $row->addChild($cell);
            }
        }
        
        
    }
    
    /**
     * @return HtmlElement the corespunding thead,tbody or tfoot
     */
    private function getRegionParent($region){
        switch ($region)
        {
            case Table::HEAD:
                return $this->thead;
            case Table::FOOT:
                return $this->tfoot;
            case Table::BODY:
            default:
                return $this->tbody;
        }
    }
}