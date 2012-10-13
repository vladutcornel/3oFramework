
<?php
/**
 * Helper file to locate all the framework classes - Auto generated
 * @package 3oLibrary
 * @author Cornel Borina <cornel@scoalaweb.com>
 */

/**
 * User defined classes
 */
global $WHEREIS_USER;
$WHEREIS_USER = array();

/**
 * TriO classes
 */
$WHEREIS = array (
  'CSSAtribute' => '/css/CSSAtribute.php',
  'CSSColor' => '/css/CSSColor.php',
  'CSSGradient' => '/css/CSSGradient.php',
  'CSSUnit' => '/css/CSSUnit.php',
  'Style' => '/css/Style.php',
  'DBModel' => '/db/DBModel.php',
  'TMysql' => '/db/mysql/TMysql.php',
  'DatabaseException' => '/exceptions/DatabaseException.php',
  'DataTypeException' => '/exceptions/DataTypeException.php',
  'UserInputException' => '/exceptions/UserInputException.php',
  'GenerateWhereis' => '/GenerateWhereis.php',
  'Element' => '/html/Element.php',
  'Link' => '/html/elements/Link.php',
  'Paragraph' => '/html/elements/Paragraph.php',
  'Table' => '/html/elements/Table.php',
  'Button' => '/html/forms/Button.php',
  'Form' => '/html/forms/Form.php',
  'FormElement' => '/html/forms/FormElement.php',
  'Hidden' => '/html/forms/Hidden.php',
  'Input' => '/html/forms/Input.php',
  'PasswordField' => '/html/forms/PasswordField.php',
  'Textarea' => '/html/forms/Textarea.php',
  'TextField' => '/html/forms/TextField.php',
  'UploadForm' => '/html/forms/UploadForm.php',
  'HtmlElement' => '/html/HtmlElement.php',
  'TGlobal' => '/TGlobal.php',
  'TObject' => '/TObject.php',
  'TOCore' => '/TOCore.php',
);


function trio_autoload($class_name){
    global $WHEREIS;
    global $WHEREIS_USER;
    // try to load TriO script class
    if (isset($WHEREIS[$class_name]))
    {
        include TRIO_DIR.'/'.$WHEREIS[$class_name];
    }
    
    // try to load User-defined class
    if (isset($WHEREIS_USER[$class_name]))
    {
        include $WHEREIS_USER[$class_name];
    }
}

/*
 * Register autoload function and set it to prepand (3rd param) so other 
 * autoload functions can be declared
 */
spl_autoload_register ('trio_autoload', true, true);

/**
 * Tell the script where to look for the invoked class.
 * You can provide a parameters list with the odd index (1st param, 3rd...) 
 * being the class names and the even parameters being the file path.
 * Or you can directly provide an associative array with the keys being the 
 * class names and the values the path.
 * You can use this as an substitute for "include ClassFile.php" since this
 * only loads the file only when needed
 * @param array $whereis array(class_name=>file_path)
 */
function trio_whereis()
{
    $first_arg = func_get_arg(0);
    if (!is_array($first_arg))
    {
        // we got a list
        $nr_args = func_num_args();
        $args = func_get_args();
        $new_args = array();
        for ($i = 1; $i < $nr_args; $i+=2)
        {
            $new_args[$args[$i-1]] = $args[$i];
        }
        trio_whereis($new_args);
        return;
    }
    global $WHEREIS_USER;
    foreach($first_arg as $class=>$file)
    {
        $WHEREIS_USER[$class] = $file;
    }
}
