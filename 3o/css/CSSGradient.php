<?php

/**
 * Define a CSS gradient. This can be linear or radial.
 * @author Cornel Borina <cornel@scoalaweb.com>
 * @package 3oScript
 */
class CSSGradient{
    /**
     * @var array The stop points of the gradient)
     */
    private $points = array();
    
    /**
     * @var string Gradient origin or angle
     */
    private $origin = "center center";
    
    /**
     * @var bool true if the gradient should repeat
     */
    private $repeat = false;
    
    /**
     * @var string the type of gradient(linear or radial)
     */
    private $type = 'linear';
    
    public function __construct($init) {
        //background: radial-gradient(ellipse at center, #1e5799 0%,#2989d8 50%,#207cca 70%,#7db9e8 100%); /* W3C */
        $valid = preg_match("/(?P<type>linear|radial)-gradient\((?P<points>[^\)]{0,},?)/i",$init,$found);
	if ($valid) {
	    $points = explode(',',$found['points']);
	    
	    // check origin
	    $origin_degrees = 0;
	    $start_point = array('vertical'=>'center', 'horizontal'=>'center');
	    $origin_parts = preg_split("/\s+/",$points[0]);
	    $found_origin = FALSE;
	    foreach($origin_parts as $part){
		$degree = preg_match('/(?P<degree>\-?[0-9]+(.[0-9]+)?deg)/i',$part,$found);
		if ($degree)
		{	// 
		    $origin_degrees = intval($found['degree']);
		    $found_origin = true;
		    break;
		}
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
	    if (!$found_origin){
		$origin_degrees = 270;
                $points = array_slice($points, 1);
	    }
	    
	    if ($origin_degrees == 0){
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
	    
            $this->origin = $origin_degrees;
            
            // register points
            $this->points = array();
            foreach ($points as $point)
            {
                $point_parts = explode(' ', $point);
                $point_array = array();
                $nr_parts = count($point_parts);
                if (1 > $nr_parts) continue;
                
                // we have at least 1 part
                if (1 == $nr_parts)
                {
                    // we have just the color
                    $point_array['color'] = new CSSColor($point);
                    $point_array['auto_position'] = true;
                } else {
                    $point_array['color'] = new CSSColor($point_parts[0]);
                    $point_array['auto_position'] = false;
                    $point_array['position'] = new CSSUnit( $point_parts[1] );
                }
                
                $this->points[]= $point_array;
            }
	    
	}
        
        
    } // function __construct
    
    private function update_positions(){
        // update the point positions
        $start_point = 0;
        $end_point = 0;
        $nr_points = count ($this->points);
        do{
            $continue = false;
            
            // find a stop point with specified position
            for ($i = $start_point; $i < $nr_points; $i++) 
            {
                $end_point = $i ;
                if (! $this->points[$i]['auto_position'])
                {
                    break;
                }
            }
            
            // update the positions for all the
        }while($continue);
        
    }// update_positions()
    
    public function toCSS($echo = true){
        
    }
}