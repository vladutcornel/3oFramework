<?php

/**
 * Wrapper for the PHP's global vars
 * If any of the requested params are not set, the methods will return an empty 
 * string, or, for the Get, Post and cookie, the programmer can specify the 
 * default return value.
 * 
 * For the GET parameters, the real browser sent parameters are used, since PHP
 * may get confused if a redirect script is used (eg. using mod_rewrite in Apache)
 * 
 * @author Cornel Borina <cornel@scoalaweb.com>
 * @package 3oScript
 */
if(!class_exists('TGlobal'))
{
    class TGlobal {
        /**
         * The actual request URL components (not confused by a redirect)
         * @static
         * @var array the url components (see http://php.net/manual/en/function.parse-url.php)
         */
        private static $request;

        /**
         * Real GET parameters, usefull if a redirect script (e.g. htaccess+mod_rewrite in Apache) is used
         * @static
         * @var array
         */
        private static $get;

        /**
         * The request variables, cached by self::request() method 
         * @see TGlobal::request()
         * @static
         * @var array
         */
        private static $request_vars = array();

        /**
         * Registers the get parameter if we're in a redirect
         */
        public static function init() {
           // register real request
           self::$request = parse_url($_SERVER['REQUEST_URI']);

           if(isset(self::$request['query']))
               parse_str(self::$request['query'], self::$get);
        }

        /**
         * Real GET parameters (as seen on browser's address bar)
         * Reason: Some server URL redirects (e.g. using htaccess in Apache) confuse PHP, so $_GET doesn't always work
         * If you need the params from a redirect, use TGlobal::script()
         * @param string $param
         * @param string $default What should be returned if there param was not found
         * @return string
         */
        public static function get($param, $default='') {
               if(!isset(self::$get[$param])) return $default;
               return self::$get[$param];
        }
        
        /**
         * GET parameters recived by PHP. Most times, it's the same as TGlobal::get()
         * @see TGlobal::get
         * @param string $param
         * @param string $default What should be returned if there param was not found
         * @return string
         */
        public static function script($param, $default='') {
               if(!isset($_GET[$param])) return $default;
               return $_GET[$param];
        }

        /**
         * Get POST parameters ($_POST)
         * @param string $param
         * @param string $default What should be returned if there param was not found
         * @return string
         */
        public static function post($param, $default = '') {
               if (! isset($_POST[$param])) return $default;
               return $_POST[$param];
        }

        /**
         * Get the cookie vars ($_COOKIE)
         * @param string $param
         * @param string $default What should be returned if there param was not found
         * @return string
         */
        public static function cookie($param, $default='') {
               if (! isset($_COOKIE[$param])) return $default;
               return $_COOKIE[$param];
        }

        /**
         * Get session vars ($_SESSION)
         * @param string $param
         * @return string
         */
        public static function session($param, $default = '')
        {
            // start the session if it is not started
            if (session_id() === "") session_start ();
            
            if (!isset($_SESSION[$param])) return $default;
            else return $_SESSION[$param];
        }
        
        /**
         * Set a session variable
         * @param type $param
         * @param type $value
         */
        public static function setSession($param, $value)
        {
            // start the session if it is not started
            if (session_id() === '') session_start ();
            
            $_SESSION[$param] = $value;
        }
        
        public static function unsetSession($param)
        {
            // start the session if it is not started
            if (session_id() === '') session_start ();
            
            unset($_SESSION[$param]);
        }

        /**
         * get enviroment variables ($_ENV)
         * @param string $param
         * @return string
         */
        public static function env($param)
        {
            if (!isset($_ENV[$param])) return "";
            else return $_ENV[$param];
        }

        /**
         * Get Server variables ($_SERVER)
         * @param type $param
         * @return string
         */
        public static function server($param)
        {
            if (!isset($_SERVER[$param])) return "";
            else return $_SERVER[$param];
        }
        
        /**
         * Get uploaded file data
         * @param string $param
         * @return boolean|array false if there is no file
         */
        public static function file($param)
        {
            if (!isset($_FILES[$param])) return false;
            else return $_FILES[$param];
        }

        /**
         * Get a request parameter
         * @param string $param the searched param
         * @param string $order the order of the searched (compatible with php/ini's 'variables_order' - http://php.net/manual/en/ini.core.php#ini.variables-order)
         * @return string
         */
        public static function request($param, $order = 'escgp')
        {
            // if we already searched for the param, we won't do it again..
            if (isset (self::$request_vars[$param]))
                return self::$request_vars[$param];

            // search for the param in the provided order
            $toreturn = "";
            $characters = array_reverse(str_split(strtolower($order)));
            foreach ($characters as $char)
            {
                switch ($char)
                {
                    case 'e':
                        if ('' != self::env($param))
                        {
                            $toreturn = self::env($param);
                            break 2;// exit foreach
                        }
                        break;
                    case 'g':
                        if ('' != self::get($param))
                        {
                            $toreturn = self::get($param);
                            break 2;// exit foreach
                        }
                        break; 
                    case 'p':
                        if ('' != self::post($param))
                        {
                            $toreturn = self::post($param);
                            break 2;// exit foreach
                        }
                        break; 
                    case 'c':
                        if ('' != self::cookie($param))
                        {
                            $toreturn = self::cookie($param);
                            break 2;// exit foreach
                        }
                        break; 
                    case 's':
                        if ('' != self::server($param))
                        {
                            $toreturn = self::server($param);
                            break 2;// exit foreach
                        }
                        break;       
                }
            }

            // save the result since this is quite expensive operation
            self::$request_vars[$param] = $toreturn;

            return $toreturn;
        }

    }
}
TGlobal::init();