<?php

require_once TRIO_DIR.'/whereis.php';

/**
 * Some utility functions wrapped in a class.
 * Note that TGlobal also implements some utility methods needed by TOCore
 * @author Cornel Borina <cornel@scoalaweb.com>
 * @package 3oFramework
 */
abstract class Util{
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
        $arr = preg_split("/[\s]+/", $str,$words+1);
	return join(' ',array_slice($arr,$start,$words));
    }
    
    public static function saveSerializedCache($data, $file, $cache_interval) {
        $interval = TGlobal::string2date($cache_interval);
        $expire = $interval->format(DateTime::ATOM);
        
        $obj = (object) array(
            'timeout'=>$expire,
            'data'=> serialize($data)
        );
        file_put_contents($file, serialize($obj));
    }
    
    /**
     * Read the contents of Cache file
     * @param string $cache_file the path to the cache file
     * @return mixed
     * @throws Exception
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
     *
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
}