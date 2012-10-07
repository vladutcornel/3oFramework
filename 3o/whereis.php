
<?php
/**
 * Helper file to locate all the framework classes - Auto generated
 * @package 3oScript
 * @author Cornel Borina <cornel@scoalaweb.com>
 */
$WHEREIS = array (
  'TObject' => '/TObject.php',
  'GenerateWhereis' => '/GenerateWhereis.php',
  'Style' => '/css/Style.php',
  'HtmlElement' => '/html/HtmlElement.php',
  'uploadForm' => '/html/forms/uploadForm.php',
  'form' => '/html/forms/form.php',
  'input' => '/html/forms/input.php',
  'hidden' => '/html/forms/hidden.php',
  'textarea' => '/html/forms/textarea.php',
  'passwordField' => '/html/forms/passwordField.php',
  'textField' => '/html/forms/textField.php',
  'button' => '/html/forms/button.php',
  'formElement' => '/html/forms/formElement.php',
  'link' => '/html/elements/link.php',
  'paragraph' => '/html/elements/paragraph.php',
  'table' => '/html/elements/table.php',
  'Element' => '/html/Element.php',
  'DBModel' => '/db/DBModel.php',
);

function __autoload($class_name){
    global $WHEREIS;
    if (isset($WHEREIS[$class_name]))
    {
        include TRIO_DIR.'/'.$WHEREIS[$class_name];
    }
}