<?php

/**
 * Define a CSS gradient. This can be linear or radial.
 * @package 3oScript
 */
class CSSGradient{
    /**
     * @var array The stop points of the gradient (point[i] = array(distance,color))
     */
    private $points = arra();
    
    /**
     * @var string Gradient origin or angle
     */
    private $angle = 0;
    
    /**
     * @var bool true if the gradient should repeat
     */
    private $repeat = false;
    
    /**
     * @var string the type of gradient(linear or radial)
     */
    private $type = 'linear';
    
    public function __construct($init){
        //background: radial-gradient(ellipse at center, #1e5799 0%,#2989d8 50%,#207cca 70%,#7db9e8 100%); /* W3C */
        $init = "linear-gradient(74deg,#f56789 20%)";
        $valid = preg_match("/(?P<type>linear|radial)-gradient\((?P<points>[^\)]{0,},?)/i",$init,$found);
        if ($valid) {
            $points = explode(',',$found['points']);
            $found_origin = $this->setAngle($points[0]);
            
            // the first index for a stop-point (0 if we have a angle defined, 1 otherwise)
            $start_index = 0
            if ($found_origin){
                $start_index = 1;
            }
            
            // the number of points for less memory
            $no_points = count($points);
            
            
            for ($i = $start_index; $i < $no_points; $i++){
                
            }
        }
    }
    
    /**
     * Set the gradient angle
     * @param float|string $point the angle or the starting point of the gradient
     */
    public function setAngle($angle){
        $points = explode(',',$angle);
            
        // check origin
        $origin_degrees = 0;
        $start_point = array('vertical'=>'center', 'horizontal'=>'center');
        $origin_parts = preg_split("/\s+/",$points[0]);
        $found_origin = FALSE;
        foreach($origin_parts as $part){
            $degree = preg_match('/(?P<degree>\-?[0-9]+(.[0-9]+)?deg)/i',$part,$found);
            if ($degree)
            {	// We found an angle, so we save it's value and stop searching
                $origin_degrees = intval($found['degree']);
                $found_origin = true;
                break;
            }
            
            // by this point, the word could be a keyword for the starting point
            switch ($part){
                case "top":
                case "bottom":
                $start_point['vertical'] = $part;
                $found_origin = true;
                break;
                case "left":
                case "right":
                $start_point['horizontal'] = $part;
                $found_origin = true;
                break;
            }
        }
        
        if (!$found_origin)
        {
            // if no valid origin was set, the default is 270 (top-down gradient)
            $origin_degrees = 270;
        }
        
        // convert the gradient keywords to degrees (easy to work with)
        if ($origin_degrees == 0)
        {
            $origin_degrees = 90;
            
            if ($start_point['horizontal'] == 'left')
                $origin_degrees =  0;
            elseif ($start_point['horizontal'] == 'right')
                $origin_degrees = 180;
            
            if ($start_point['vertical'] == 'top')
                $origin_degrees = -((90 + $origin_degrees)/2);
            elseif ($start_point['vertical'] == 'bottom')
                $origin_degrees = ((90 + $origin_degrees)/2);
        }
        
        // make sure the degree is in [0,365] range
        $origin_degrees %= 360;
        // we finally have what we need
        $this->angle = $origin_degrees;
        
        return $found_origin;
    }
    
    /**
     * Adjust the angle by an offset
     * @param float $offset
     * @param int $direction 
     */
    function adjustAngle($offset, $direction = 1){
        // change the sighn of the offset if we have to
        if ($direction < 0) $offset*=-1;
        
        // modify the angle
        $this->angle += $offset;
        
        // make the angle in [0,359]
        $this->angle %= 360;
        
        // make ange positive
        if ($this->angle < 0){
            $this->angle+=360;
        }
    }
    
    /**
     * Add a gradient sop-point.
     * @param string $stop_point A TOColor or valid CSS color and it's offset
     * @param int $offset if the first parameter is a CSS color, use this to specify an offset
     */
    function addPoint($color, $offset = 'auto')
    {
        $trio_color = null;
        if ($color instanceof CSSColor){
            $trio_color = $color;
        }else {
            // we have a string
            $parts = preg_split("/s+/", $color);
            
            // try to determine the color
            foreach($parts as $part){
                try{
                    $trio_color = new CSSColor($part);
                }catch(NotAColor $e){
                    // probably the offset
                    $is_number = preg_match("#\-?[0-9]+#", $part, $matches);
                    if ($is_number){
                        $offset = intval($matches[0]);
                    }// if number
                }// catch (not a color)    
            }// foreach
            
        }// else ($color is a string)
        
        if (!is_null($trio_color)){
            if ('auto' == $offset)
            {
                $this->points[] = $trio_color;
            } else{
                $this->points[$offset."%"] = $trio_color;
            }
        }
    }
    
    /**
     * Generate Cross-Browser Code
     * @todo add suport for old browsers
     * @todo make teh support for each browser settable
     */
    public function getCrossBrowser($browsers = 1){
        
        $css = "background-image: -webkit-{$this}";
        $css.= "background-image: -moz-{$this}";
        $css.= "background-image: -o-{$this}";
        $css.= "background-image: {$this}";
        
        return $css
    }
    
    /**
     * Return a w3c compatible gradient
     */
    public function __toString(){
        $string = "linear-gradient("
        $string.= $this->angle."deg"
        foreach($this->points as $offset=> $color){
            $string.=",{$color}";
            if (is_nan($offset)){
                $string.= $offset." ";
            }
        }
        $string.=")";
        
        return $string;
    }
}