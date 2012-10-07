<?php
/**
 * Generate Whereis file - for 3oScript only
 *
 * @author cornel
 */
class GenerateWhereis {
    var $whereis = array();
    var $basedir = '/';

    function main(){
        $this->basedir = __DIR__;
        $this->read_dir();
        echo $file = '<?php
/**
 * Helper file to locate all the framework classes - Auto generated
 * @package 3oScript
 * @author Cornel Borina <cornel@scoalaweb.com>
 */
$WHEREIS = '.\var_export($this->whereis, true).';

define(\'TRIO_DIR\', __DIR__);

function __autoload($class_name){
    global $WHEREIS;
    if (isset($WHEREIS[$class_name]))
    {
        include TRIO_DIR.\'/\'.$WHEREIS[$class_name];
    }
}';
    }

    /**
     * Recurseve method to generate $whereis
     * @param type $dir
     */
    function read_dir($dir = '') {
        // from PHP Manual
        if ($handle = opendir($this->basedir.'/'.$dir)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry == "." || $entry == "..") {
                    continue;
                }
                if (\in_array($entry, array(
                    'whereis.php'
                )))
                {
                    continue;
                }

                if (\is_dir($this->basedir.'/'.$dir.'/'.$entry)){
                    $this->read_dir($dir.'/'.$entry);
                    continue;
                }

                $class_name = \basename($entry,'.php');
                $this->whereis[$class_name] = $dir.'/'.$entry;
            }
            closedir($handle);
        }
    }
}