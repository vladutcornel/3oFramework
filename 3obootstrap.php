<?php
// load the Trio Core framework
require_once __DIR__.'/3o/framework-core.php';

// SITE_ROOT is needed by TOCore to load the appropriate file if the website is 
// in a subdirectory (like http://example.com/trio/)
define ('SITE_ROOT',__DIR__);

// not required, but usefull - change this with your value
define ('URL_ROOT','/3oCore');

// start the Trio Core Framework
TOCore::main();
