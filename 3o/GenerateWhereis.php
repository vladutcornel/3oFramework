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
        
        $file = '<?php
/**
 * Helper file to locate all the framework classes - Auto generated
 * @package 3oScript
 * @author Cornel Borina <cornel@scoalaweb.com>
 */
$WHEREIS = '.\var_export($this->whereis, true).';

function trio_autoload($class_name){
    global $WHEREIS;
    if (isset($WHEREIS[$class_name]))
    {
        include TRIO_DIR.\'/\'.$WHEREIS[$class_name];
    }
}
/*
 * Register autoload function and set it to prepand (3rd param) so other autoload functions can be declared
 */
spl_autoload_register (\'trio_autoload\', true, true);';
        /*
         * Only dump the file contents so we won't accidentaly overwrite important things
         */
        echo '<pre>';
        highlight_string($file);
        echo '</pre>';
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