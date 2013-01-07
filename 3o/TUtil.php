<?php

require_once TRIO_DIR.'/framework-core.php';

/**
 * Some utility functions wrapped in a class.
 * @author Cornel Borina <cornel@scoalaweb.com>
 * @package 3oFramework
 * @subpackage Core
 */
abstract class TUtil{
    final function __construct(){}

    /**
     * Extracts a portion of the text from the word at the starting position
     * @param string $input the input text
     * @param int $start Witch word to start from (0 = first)
     * @param int $chunk The number of words to return
     * @return string
     */
    public static function word_slice($input, $start = 0, $words = 80)
    {
        $arr = preg_split("/[\s]+/", $input,$words+1);
	return join(' ',array_slice($arr,$start,$words));
    }
    
    /**
     * Save data as cache into a file using the serialize function.
     * 
     * @param mixed $data the data to be saved
     * @param file $file where to save it
     * @param time $cache_interval
     */
    public static function saveSerializedCache($data, $file, $cache_interval) {
        $interval = self::string2date($cache_interval);
        $expire = $interval->format(DateTime::ATOM);
        
        $obj = (object) array(
            'timeout'=>$expire,
            'data'=> serialize($data)
        );
        file_put_contents($file, serialize($obj));
    }
    
    /**
     * Read the contents of Cache file.
     * If the data is to old, false is returned
     * @param string $cache_file the path to the cache file
     * @return mixed the cached data or false if it is too old or for some reason it's not accesible
     */
    public static function readSerializedCache($cache_file)
    {
        try{
            if (!file_exists($cache_file))
            {
                throw new Exception;
            }
            $contents = file_get_contents($cache_file);
            if ($contents == false)
            {
                // == works here insted of === because empty string is equaly bad
                throw new Exception;
            }
            $json = unserialize($contents);
            if (false == $json)
            {
                throw new Exception;
            }

            if (!isset($json->timeout) || !isset($json->data))
            {
                throw new Exception;
            }

            $expire = new DateTime($json->timeout);
            if ($expire->getTimestamp() <= time())
            {
                throw new Exception;
            }
            return unserialize($json->data);
        }  catch (Exception $e){
            return false;
        }
    }
    
    /**
     * Change the class of an object
     * Warning! The original object is changed
     * @param object $obj the object to be converted
     * @param string $class_type the new class name
     * @author toma at smartsemantics dot com
     * @see http://www.php.net/manual/en/language.types.type-juggling.php#50791
     */
    public static function changeClass(&$obj, $class_type) {
        if (class_exists($class_type, true)) {
            $obj =
                unserialize(
                    preg_replace(
                            "/^O:[0-9]+:\"[^\"]+\":/i", "O:" . strlen($class_type) . ":\"" . $class_type . "\":", serialize($obj)
                    )
                );// unserialize
        }// if class exists
    }// changeClass()
    
    /**
     * Helper function to determine if the provided variable can be iterated 
     * by foreach (it's an object or an array).
     * 
     * @param mixed $var the tested variable
     * @return boolean true if it can be used in a foreach
     */
    public static function isIterable($var) {
        return (is_array($var) || is_object($var));
    }
    
    /**
     * Creates a DateTime object form a string, a DateInterval or a ISO8601 
     * interval (P<date>T<time>, used by DateInterval Constructor)
     * @param mixed $string
     * @return \DateTime
     * @throws DomainException  when the string can not be evaluated eather way.
     * @todo This may be better in a separate class
     */
    public static function string2date($string) {
        if ($string instanceof DateTime)
            // we've got a DateTime
            return $string;
        if ($string instanceof DateInterval)
            // add the interval to current date
            return date_create()->add($string);
        try {
            // for relative format - will throw an Exception if the time is in the wrong format
            $time = new DateTime($string);
            return $time;
        } catch (Exception $e) {
            
        }
        // for P...T... format (ISO 8601)
        $interval = new DateInterval($string);
        return date_create()->add($interval);
    }
    
    
    /**
     * Populate an array or an object with the specified default values if those 
     * are not set already.
     * @param object|array $original Theoriginal object/array
     * @param object|array $defaults An object/array containing the default values
     * @return object|array The original array or object with the default values set
     * @throws UnexpectedValueException
     */
    public static function populate($original, $defaults) {
        // determine if the original is an object or an array
        $using_array = true;
        if (is_object($original)) {
            $using_array = false;
        } elseif (!is_array($original)) {
            // I don't know what to do with this...
            throw new UnexpectedValueException('the first parameter from TUtil::populate should be eather an array or an object.' . gettype($original) . ' was given');
        }

        // determine if the default is an array or object
        if (!self::isIterable($defaults)) {
            // foreach will complain with this
            throw new UnexpectedValueException('the second parameter from TUtil::populate should be eather an array or an object.' . gettype($original) . ' was given');
        }

        // populate all values that are not already set
        foreach ($defaults as $key => $value) {
            if ($using_array && !isset($original[$key])) {
                $original[$key] = $value;
            } elseif (!$using_array && !isset($original->$key)) {
                $original->$key = $value;
            }
        }

        return $original;
    }
}