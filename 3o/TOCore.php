<?php

if (!defined('SITE_ROOT')) {
    define('SITE_ROOT', $_SERVER['DOCUMENT_ROOT']);
}

if (!defined('TRIO_DIR'))
    define('TRIO_DIR', __DIR__);
require_once TRIO_DIR . '/framework-core.php';

/**
 * The center of 3OScript redirect mechanism
 * It determines the php file that should be loaded.
 * For non-php files, it just dumpes the contents and sets the Mime type
 * accordinglly
 * @author Cornel Borina <cornel@scoalaweb.com>
 * @package 3oFramework
 * @subpackage Core
 */
class TOCore {

    /**
     * @staticvar array The extra params of the array
     */
    public static $params = array();

    /**
     * 
     * @var the request params
     * @see http://php.net/manual/en/function.parse-url.php
     */
    public static $request;

    /**
     * The file name for the file loaded by the current script
     * @var string
     */
    public static $file = '';

    /**
     * The file path (relative to SITE_ROOT) loaded by the current script
     * @var string
     */
    public static $file_path = '';

    /**
     * The class loaded by the current script
     * @var string
     */
    public static $main_class = '';
    
    /**
     * List of prefixes for the main class.
     * @var array
     */
    public static $prefixes = array('Page', 'Page_', 'P');

    /**
     * This loads the requested page from a .php file
     * @param $page string the requested URI
     * @return The loaded filename, without extension
     */
    public static function load($page = '') {
        // if there is no page, we use the index
        if ($page == '')
            $page = 'index';

        // get the virtual directories
        $parts = explode('/', $page);

        if (is_dir(SITE_ROOT . '/' . $page) && file_exists(SITE_ROOT . '/' . $page . '/index.php')) {
            // a directory with index.php was requested
            $page.= '/index.php';
            $parts[] = 'index';
            include_once $page;
        } elseif (file_exists(SITE_ROOT . '/' . $page) && is_file(SITE_ROOT . '/' . $page)) {
            // load the requested file
            $fileinfo = pathinfo(SITE_ROOT . '/' . $page);

            $last = count($parts) - 1;
            $parts[$last] = $fileinfo['filename'];



            if ($fileinfo['extension'] != 'php') {
                // it's not a php script
                header("Content-Type: " . mime_content_type(SITE_ROOT . '/' . $page));
                echo file_get_contents(SITE_ROOT . '/' . $page);

                die();
            }

            include_once SITE_ROOT . '/' . $page;
        } elseif (file_exists(SITE_ROOT . '/' . $page . '.php')) {
            // the file was requested without .php extension
            include_once SITE_ROOT . '/' . $page . '.php';
        } else {
            // no luck so far, we try loading the parent directory
            $parent_dir = implode('/', array_slice($parts, 0, -1));
            if ($parent_dir != '') {
                $slice = array_slice($parts, -1);
                array_unshift(self::$params, $slice[0]);
                return self::load($parent_dir);
            }

            if (file_exists(SITE_ROOT . '/index.php')) {
                // try to load the homepage.
                return self::load("index");
            }

            // we still couldn't find a file to load
            echo '<p>Error:file not found</p>';
        }

        // save the loaded file path
        static::$file_path = implode('/', $parts).'.php';
        
        // return the filename, so we can figure the class to load
        return $parts[count($parts) - 1];
    }
    
    /**
     * Sets and returns the main class for the requested file.
     * To avoid name conflicts with Library's classes, the main class can have a prefix
     * @return boolean|string
     */
    public static function find_main_class()
    {
        
        // The class name should only contain letters, numbers or underscores ("_")
        static::$main_class = preg_replace('/[^a-z0-9_]+/i', '_', static::$file);
        
        if (!TUtil::isIterable(static::$prefixes))
        {
            throw new UnexpectedValueException('Please provide an array or an object for main class prefix');
        }
        
        foreach (static::$prefixes as $prefix) {
            if (class_exists($prefix.static::$main_class)){
                return (static::$main_class = $prefix.static::$main_class);
            }
        }
        
        if (class_exists(static::$main_class))
        {
            return static::$main_class;
        }
        
        return false;
    }

    /**
     * Tells weather or not this is a AJAX request.
     * The request is tought to be AJAX if HTTP_X_REQUESTED_WITH header is set to 'XMLHttpRequest'
     * or, more reliably, the request parameter(eather via post, or via get) is 'ajax'
     * @return boolean
     */
    public static function isAjax() {
        return
                (TGlobal::server('HTTP_X_REQUESTED_WITH') === 'XMLHttpRequest')
                ||
                (TGlobal::request('request','','pgx') == 'ajax');
    }

    /**
     * Tells weather or not this is a CSS request.
     * The request is tought to be CSS if the 'request' parameter(eather via post, or via get) is 'css'
     * @return boolean
     */
    public static function isCss() {
        return (TGlobal::request('request','','pgx') == 'css');
    }

    /**
     * Tells weather or not this is a JavaScript request.
     * The request is tought to be JavaScript if the 'request' parameter(eather via post, or via get) is 'js'
     * @return boolean
     */
    public static function isJavascript() {
        return (TGlobal::request('request','','pgx') == 'js');
    }
    
    /**
     * Load the appropriate method from the given class.
     * This assumes the class file is loaded or loadable via the whereis mechanism.
     * This is used by TOCore to load the main class, but can be used load other
     * class as if it was the main class
     * @param string|object $class
     * @throws TOCoreException when there is no main method in the class
     */
    public static function parse($class){
        
        if(!is_object($class)){
            $page = new $class(self::$params);
        } else {
            $page = $class;
        }
        
        if ('POST' == TGlobal::server('REQUEST_METHOD') && method_exists($page, 'post_request')) {
            $page->post_request(self::$params);
        } elseif (method_exists($page, 'get_request')) {
            $page->get_request(self::$params);
        }
        
        if (self::isAjax() && method_exists($page, 'ajax')) {
            //run the main AJAX method
            $page->ajax(self::$params);
        } else {

            if (self::isJavascript() && method_exists($page, 'javascript')) {
                // run Javascript method
                $page->javascript(self::$params);
            } elseif (self::isCss() && method_exists($page, 'css')) {
                // run CSS method
                $page->css(self::$params);
            } elseif (method_exists($page, 'main')) {
                // run the main method
                $page->main(self::$params);
            } else {
                // No main method. The fun is over
                throw new TOCoreException(self::$file, TOCoreException::NO_MAIN);
            }
        }

    }

    /**
     * The main function for the TOCore class. This is loaded by default.
     * It loads the appropriate file and an object of the main class
     * (that should have the same name as the file)
     *
     * Unless it's a AJAX request and the ajax() method is provided, based on 
     * the request type (POST or GET), it will try to fire get_request() or post_request()
     * 
     * Then it tries to invoke the appropriate method for the request
     * (ajax, javascript, css) or the main() method that should be in all the
     * class files ment for display.
     */
    public static function main() {

        // turn on output buffering so nothing is isplayed unless everything is OK
        ob_start();

        //
        $queryArray = array();

        static::$file = "";
        if ('' != TGlobal::server('REDIRECT_QUERY_STRING')) {
            // We are here probably by a redirect, so load the page
            parse_str(TGlobal::server('REDIRECT_QUERY_STRING'), $queryArray);
            $page = $queryArray['page'];
            static::$file = self::load($page);
        } else {
            // We are here organic (via include or require),
            // so we should figure the name of the file
            static::$file = basename(TGlobal::server('PHP_SELF'), ".php");
        }


        // We have the name, let's run the script...

        if (static::find_main_class()) {
            
            self::parse(new static::$main_class(static::$params));
            
        } else {
            // The class is not declared (corectly)
            throw new TOCoreException(static::$file,  TOCoreException::NO_CLASS);
        }

        ob_end_flush();
    }

}

class TOCoreException extends Exception{
    const NO_CLASS = 1;
    const NO_MAIN = 2;
    public $request_file = '';
    
    public function __construct($file, $code, $previous) {
        switch($code){
            case self::NO_CLASS:
                $message = 'Can\'t find the main class.
                    Please create a ' . $file . ' class in ' . $file . '.php</p>';
                break;
            case self::NO_MAIN:
                $message = 'There is no method main() in the ' . $file . '.php class file.
                    The script can not be loaded';
                break;
            default:
                $message = 'Undefined TOCore exception';
        }
        parent::__construct($message, $code, $previous);
        $this->request_file = $file;
    }
}
