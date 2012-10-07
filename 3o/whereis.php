<?php
/**
 * Helper file to locate all the framework classes - Auto generated
 * @package 3oScript
 * @author Cornel Borina <cornel@scoalaweb.com>
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
    if (isset($WHEREIS[$class_name]))
    {
        include TRIO_DIR.'/'.$WHEREIS[$class_name];
    }
}
/*
 * Register autoload function and set it to prepand (3rd param) so other autoload functions can be declared
 */
spl_autoload_register ('trio_autoload', true, true);